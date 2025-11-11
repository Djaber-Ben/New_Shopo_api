<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Helpers\MapHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Mail\AdminNewSubscriptionNotification;

class StoreApiController extends Controller
{

  /**
   * Display all avilable nearby stores.
   */
  public function nearby(Request $request)
  {
    $validator = Validator::make($request->query(), [
      'latitude' => 'required|numeric|between:-90,90',
      'longitude' => 'required|numeric|between:-180,180',
      'radius' => 'nullable|numeric|min:1|max:100',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Invalid location coordinates or radius',
        'errors' => $validator->errors(),
      ], 422);
    }

    $latitude = $request->query('latitude');
    $longitude = $request->query('longitude');
    $radius = $request->query('radius', 50);

    \Log::info("📍 Searching stores near $latitude, $longitude within $radius km");


    $storesWithCoords = Store::selectRaw("
            stores.*,
            (6371 * acos(cos(radians(?))
            * cos(radians(latitude))
            * cos(radians(longitude) - radians(?))
            + sin(radians(?))
            * sin(radians(latitude)))) AS distance
        ", [$latitude, $longitude, $latitude])
      ->whereNotNull('latitude')
      ->whereNotNull('longitude')
      ->where('status', 'active')
      ->orderBy('distance', 'asc')
      ->get();


    $storesWithoutCoords = Store::where(function ($q) {
      $q->whereNull('latitude')->orWhereNull('longitude');
    })
      ->where('status', 'active')
      ->get()
      ->map(function ($s) {
        $s->distance = null;
        return $s;
      });


    $allStores = $storesWithCoords->concat($storesWithoutCoords);


    $allStores = $allStores->map(function ($store) {
      $vendor = \App\Models\User::find($store->vendor_id);

      return [
        'id' => $store->id,
        'vendor_id' => $store->vendor_id,
        'category_id' => $store->category_id,
        'store_name' => $store->store_name,
        'description' => $store->description,
        'logo' => $store->logo,
        'image' => $store->image,
        'phone_number' => $store->phone_number,
        'address' => ($store->address !== 'Not specified') ? $store->address : '',
        'address_url' => $store->address_url,
        'latitude' => $store->latitude,
        'longitude' => $store->longitude,
        'city' => $store->city,
        'wilaya' => $store->wilaya,
        'distance' => $store->distance,
        'vendor' => $vendor ? [
          'id' => $vendor->id,
          'name' => $vendor->name,
          'email' => $vendor->email,
          'image' => $vendor->image,
          'phone_number' => $vendor->phone_number,
          'user_type' => $vendor->user_type,
        ] : null,
      ];
    });


    return response()->json([
      'status' => true,
      'user_location' => ['lat' => $latitude, 'lng' => $longitude],
      'radius_km' => $radius,
      'stores_count' => $allStores->count(),
      'stores' => $allStores->values(),
    ]);
  }


  /**
   * Display all available stores.
   */
  public function index()
  {
    try {
      // Get all active stores
      $stores = Store::where('status', 'active')->get();

      \Log::info('Total stores found: ' . $stores->count());

      // Manually load vendor data to ensure it's there
      $storesWithVendor = $stores->map(function ($store) {
        $vendor = User::find($store->vendor_id);
        \Log::info('Store: ' . $store->store_name . ', Vendor ID: ' . $store->vendor_id . ', Vendor: ' . ($vendor ? $vendor->name : 'NOT FOUND'));

        return [
          'id' => $store->id,
          'vendor_id' => $store->vendor_id,
          'category_id' => $store->category_id,
          'store_name' => $store->store_name,
          'description' => $store->description,
          'logo' => $store->logo,
          'image' => $store->image,
          'phone_number' => $store->phone_number,
          'address' => ($store->address !== 'Not specified') ? $store->address : '',
          'address_url' => $store->address_url,
          'latitude' => $store->latitude,
          'longitude' => $store->longitude,
          'city' => $store->city,
          'wilaya' => $store->wilaya,
          'status' => $store->status,
          'created_at' => $store->created_at,
          'updated_at' => $store->updated_at,
          'vendor' => $vendor ? [
            'id' => $vendor->id,
            'name' => $vendor->name,
            'email' => $vendor->email,
            'image' => $vendor->image,
            'logo' => $vendor->logo,
            'phone_number' => $vendor->phone_number,
            'user_type' => $vendor->user_type,
          ] : null,
        ];
      });

      return response()->json([
        'status' => true,
        'stores' => $storesWithVendor,
      ], 200);

    } catch (\Exception $e) {
      \Log::error('Store Index Error: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());

      return response()->json([
        'status' => false,
        'message' => 'Failed to fetch stores',
        'error' => $e->getMessage(),
      ], 500);
    }
  }


  /**
   * Return the authenticated user and all available categories.
   */
  public function create()
  {
    $user = Auth::user();
    $categories = Category::all();

    return response()->json([
      'user' => $user,
      'categories' => $categories,
    ], 200);
  }

  /**
   * Extract latitude & longitude from a Google Maps link, coordinates, or address.
   * Handles short URLs, long URLs, and plain addresses.
   */
  public function extractCoordinates($input)
  {
    if (empty($input)) {
      \Log::warning('⚠️ Empty location input provided');
      return null;
    }

    \Log::info('Extracting coordinates from: ' . $input);

    try {
      // Handle direct "lat,lng"
      if (preg_match('/^-?\d+\.\d+,-?\d+\.\d+$/', $input)) {
        [$lat, $lng] = explode(',', $input);
        return ['latitude' => (float) $lat, 'longitude' => (float) $lng];
      }

      // Expand short link (maps.app.goo.gl or goo.gl)
      if (strpos($input, 'maps.app.goo.gl') !== false || strpos($input, 'goo.gl') !== false) {
        $expanded = $this->expandShortUrl($input);
        if ($expanded) {
          \Log::info('Expanded short link to: ' . $expanded);
          $input = $expanded;
        } else {
          \Log::warning('Could not expand short URL: ' . $input);
        }
      }

      //Try regex extraction first
      $patterns = [
        '/@(-?\d+\.\d+),(-?\d+\.\d+)/',
        '/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/',
        '/q=(-?\d+\.\d+),(-?\d+\.\d+)/',
        '/ll=(-?\d+\.\d+),(-?\d+\.\d+)/',
        '/center=(-?\d+\.\d+),(-?\d+\.\d+)/',
        '/query=(-?\d+\.\d+),(-?\d+\.\d+)/',
      ];

      foreach ($patterns as $pattern) {
        if (preg_match($pattern, $input, $m)) {
          \Log::info("Extracted from URL: {$m[1]}, {$m[2]}");
          return ['latitude' => (float) $m[1], 'longitude' => (float) $m[2]];
        }
      }

      //Try to extract readable address text from the Google Maps URL
      if (strpos($input, 'google.com/maps/place/') !== false) {
        $path = urldecode(parse_url($input, PHP_URL_PATH));
        $cleanAddress = trim(str_replace(['/maps/place/', '+'], [' ', ' '], $path));
        $cleanAddress = preg_replace('/\s+/', ' ', $cleanAddress);
        \Log::info("📍 Extracted place text for geocoding: " . $cleanAddress);
      } else {
        $cleanAddress = $input;
      }

      //Use OpenStreetMap for final geocoding
      $encoded = urlencode($cleanAddress);
      $osmUrl = "https://nominatim.openstreetmap.org/search?q={$encoded}&format=json&limit=1";

      $client = new \GuzzleHttp\Client(['timeout' => 10]);
      $response = $client->get($osmUrl, [
        'headers' => ['User-Agent' => 'Laravel-Geocoder/1.0'],
      ]);

      if ($response->getStatusCode() === 200) {
        $data = json_decode($response->getBody(), true);
        if (!empty($data) && isset($data[0]['lat'], $data[0]['lon'])) {
          $lat = (float) $data[0]['lat'];
          $lng = (float) $data[0]['lon'];
          \Log::info("Fallback geocoding success: $lat, $lng");
          return ['latitude' => $lat, 'longitude' => $lng];
        }
      }

      \Log::warning(" No coordinates found after all attempts for: " . $input);
    } catch (\Throwable $e) {
      \Log::error('Coordinate extraction failed: ' . $e->getMessage());
    }

    return null;
  }

  /**
   * Expand short Google URLs using cURL.
   */
  private function expandShortUrl($shortUrl)
  {
    try {
      $ch = curl_init($shortUrl);
      curl_setopt($ch, CURLOPT_NOBODY, true);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, true);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
      curl_exec($ch);

      $expanded = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
      curl_close($ch);

      return $expanded ?: null;
    } catch (\Throwable $e) {
      \Log::warning('Failed to expand URL: ' . $e->getMessage());
      return null;
    }
  }



  /**
   * Store a newly created store in the database.
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'category_id' => 'required|exists:categories,id',
      'store_name' => 'required|string|max:255',
      'phone_number' => 'required|string|max:20',
      'address' => 'required|string|max:500',
      'address_url' => 'required|string|max:500',
      'city' => 'required|string|max:255',
      'wilaya' => 'required|string|max:255',
      'description' => 'nullable|string',
      'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'whatsapp' => 'nullable|url|max:255',
      'facebook' => 'nullable|url|max:255',
      'instagram' => 'nullable|url|max:255',
      'tiktok' => 'nullable|url|max:255',
      // ✅ New optional subscription fields:
      'subscription_plan_id' => 'nullable|integer|exists:subscription_plans,id',
      'payment_receipt_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Validation failed',
        'errors' => $validator->errors(),
      ], 422);
    }

    $user = Auth::user();
    if (!in_array($user->user_type, ['client', 'pending'])) {
      return response()->json([
        'status' => false,
        'message' => 'Only clients or pending users can become vendors.',
      ], 403);
    }

    $user->update(['user_type' => 'vendor']);

    // ✅ Handle coordinates
    $latitude = null;
    $longitude = null;
    $mapUrl = trim($request->address_url);
    if (preg_match('/^-?\d+\.\d+,-?\d+\.\d+$/', $mapUrl)) {
      [$latitude, $longitude] = explode(',', $mapUrl);
      $latitude = (float) $latitude;
      $longitude = (float) $longitude;
    } else {
      $coords = $this->extractCoordinates($mapUrl);
      if ($coords) {
        $latitude = $coords['latitude'];
        $longitude = $coords['longitude'];
      }
    }

    // ✅ Create store first
    $store = Store::create([
      'vendor_id' => $user->id,
      'category_id' => $request->category_id,
      'store_name' => $request->store_name,
      'description' => $request->description,
      'phone_number' => $request->phone_number,
      'address' => $request->address,
      'address_url' => $request->address_url,
      'latitude' => $latitude,
      'longitude' => $longitude,
      'city' => $request->city,
      'wilaya' => $request->wilaya,
      'logo' => $request->hasFile('logo')
        ? $request->file('logo')->store('images/stores/logos', 'public')
        : null,
      'image' => $request->hasFile('image')
        ? $request->file('image')->store('images/stores/thumbnails', 'public')
        : null,
      'status' => 'active', // may change later depending on subscription
      'whatsapp' => $request->whatsapp,
      'facebook' => $request->facebook,
      'instagram' => $request->instagram,
      'tiktok' => $request->tiktok,
    ]);

    // ✅ Handle subscription plan (if provided)
    if ($request->filled('subscription_plan_id')) {
      try {
        $subscriptionPlan = \App\Models\SubscriptionPlan::where('id', $request->subscription_plan_id)
          ->where('is_active', true)
          ->firstOrFail();

        $start = now();
        $end = $subscriptionPlan->duration_days
          ? $start->copy()->addDays($subscriptionPlan->duration_days)
          : null;

        if (!empty($subscriptionPlan->is_trial) && $subscriptionPlan->is_trial) {
          // Trial plan
          $store->update([
            'subscription_expires_at' => $end,
            'status' => 'active',
          ]);

          $subscription = \App\Models\StoreSubscription::create([
            'store_id' => $store->id,
            'subscription_plan_id' => $subscriptionPlan->id,
            'start_date' => $start,
            'end_date' => $end,
            'status' => 'active',
          ]);

          return response()->json([
            'status' => true,
            'message' => 'Store created successfully with trial subscription until ' . $end->toFormattedDateString(),
            'store' => $store,
            'subscription' => $subscription,
          ], 201);
        } else {
          // Paid plan (pending until admin approves)
          $store->update(['status' => 'inactive']);

          $payment_receipt_image = null;
          if ($request->hasFile('payment_receipt_image')) {
            $payment_receipt_image = $request->file('payment_receipt_image')
              ->store('images/storeSubscriptions/payment_receipt_image', 'public');
          }

          $subscription = \App\Models\StoreSubscription::create([
            'store_id' => $store->id,
            'subscription_plan_id' => $subscriptionPlan->id,
            'payment_receipt_image' => $payment_receipt_image,
            'status' => 'pending',
            'start_date' => $start,
            'end_date' => $end,
          ]);

          // Optionally: notify admin
          if (class_exists(\App\Mail\AdminNewSubscriptionNotification::class)) {
            \Mail::to('admin@mail.com')->send(
              new AdminNewSubscriptionNotification($store, $subscription)
            );
          }

          return response()->json([
            'status' => true,
            'message' => 'Store created successfully, but inactive until admin approves the payment.',
            'store' => $store,
            'subscription' => $subscription,
          ], 201);
        }
      } catch (\Throwable $e) {
        \Log::error('Subscription creation failed: ' . $e->getMessage());
        $store->delete();
        return response()->json([
          'status' => false,
          'message' => 'Failed to create subscription plan. Store creation rolled back.',
          'error' => $e->getMessage(),
        ], 500);
      }
    }

    // ✅ Default response (no subscription)
    return response()->json([
      'status' => true,
      'message' => 'Store created successfully',
      'store' => $store,
    ], 201);
  }
      


  /**
   * Display the specified store only for the store owner.
   */
  public function edit($id)
  {
    $store = Store::where('vendor_id', Auth::id())->with('category')->findOrFail($id);

    return response()->json([
      'store' => $store,
    ], 200);
  }

  /**
   * Display the specified store to all users.
   */
  public function show($id)
  {
    $store = Store::with('category')
      ->findOrFail($id);

    return response()->json([
      'store' => $store,
    ], 200);
  }

  /**
   * Update 
   */
  public function update(Request $request, $id)
  {
    try {
      $store = Store::where('vendor_id', Auth::id())->findOrFail($id);
      $user = Auth::user();

      // Validate 
      $validator = Validator::make($request->all(), [
        'category_id' => 'sometimes|exists:categories,id',
        'store_name' => 'sometimes|string|max:255',
        'phone_number' => 'sometimes|string|max:20',
        'address' => 'sometimes|string|max:500',
        'address_url' => 'nullable|string|max:500',
        'city' => 'nullable|string|max:255',
        'wilaya' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'whatsapp' => 'nullable|url|max:255',
        'facebook' => 'nullable|url|max:255',
        'instagram' => 'nullable|url|max:255',
        'tiktok' => 'nullable|url|max:255',
      ]);

      if ($validator->fails()) {
        return response()->json([
          'status' => false,
          'message' => 'Validation failed',
          'errors' => $validator->errors(),
        ], 422);
      }

      // Extract coordinates
      $latitude = $store->latitude;
      $longitude = $store->longitude;

      if ($request->filled('address_url')) {
        $mapUrl = trim($request->address_url);

        if (preg_match('/^-?\d+\.\d+,-?\d+\.\d+$/', $mapUrl)) {
          [$latitude, $longitude] = explode(',', $mapUrl);
          $latitude = (float) $latitude;
          $longitude = (float) $longitude;
          \Log::info("Direct coordinates updated: $latitude, $longitude");
        } else {
          $coords = $this->extractCoordinates($mapUrl);
          if ($coords) {
            $latitude = $coords['latitude'];
            $longitude = $coords['longitude'];
            \Log::info("Coordinates extracted from link: $latitude, $longitude");
          }
        }
      }

      $data = $request->only([
        'category_id',
        'store_name',
        'description',
        'phone_number',
        'address',
        'address_url',
        'city',
        'wilaya',
        'whatsapp',
        'facebook',
        'instagram',
        'tiktok'
      ]);

      if ($request->hasFile('logo')) {
        if ($store->logo)
          Storage::disk('public')->delete($store->logo);
        $data['logo'] = $request->file('logo')->store('images/stores/logos', 'public');
      }

      if ($request->hasFile('image')) {
        if ($store->image)
          Storage::disk('public')->delete($store->image);
        $data['image'] = $request->file('image')->store('images/stores/thumbnails', 'public');
      }

      // ✅ CRITICAL FIX: If store has no image, use user's profile image
      if (empty($store->image) && !$request->hasFile('image') && !empty($user->image)) {
        $data['image'] = $user->image;
        \Log::info("✅ Setting store image from user profile: {$user->image}");
      }

      // Update coordinates
      if (!empty($latitude) && !empty($longitude)) {
        $data['latitude'] = $latitude;
        $data['longitude'] = $longitude;
      }

      // Save all changes at once
      $store->update($data);

      \Log::info("✅ Store #{$id} updated successfully");

      return response()->json([
        'status' => true,
        'message' => 'Store updated successfully',
        'store' => $store->fresh(),
      ], 200);
    } catch (\Throwable $e) {
      \Log::error('❌ Store update failed: ' . $e->getMessage());
      return response()->json([
        'status' => false,
        'message' => 'Failed to update store',
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * Remove the specified store from the database.
   */
  public function destroy($id)
  {
    $store = Store::where('vendor_id', Auth::id())->findOrFail($id);
    $store->delete();

    return response()->json([
      'message' => 'Store deleted successfully',
    ], 200);
  }

  /**
   * Get all stores belonging to a specific user
   */
  public function userStores($id)
  {
    try {
      $stores = Store::where('vendor_id', $id)->get();

      return response()->json([
        'status' => true,
        'stores' => $stores,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => 'Failed to fetch user stores',
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * Auto-create a simple store for users publishing their first product
   */
  public function autoCreate(Request $request)
  {
    try {
      $user = Auth::user();

      // Check if user already has a store
      $existingStore = Store::where('vendor_id', $user->id)->first();
      if ($existingStore) {
        if ($user->user_type !== 'vendor') {
          $user->user_type = 'vendor';
          $user->save();
        }

        // ✅ CRITICAL FIX: Update store image from user's profile image
        if (!$existingStore->image && $user->image) {
          $existingStore->image = $user->image;
          $existingStore->save();
        }
        // ✅ Also update city/wilaya from user if missing
        if (empty($existingStore->city) && !empty($user->city)) {
          $existingStore->city = $user->city;
        }
        if (empty($existingStore->wilaya) && !empty($user->wilaya)) {
          $existingStore->wilaya = $user->wilaya;
        }
        if (empty($existingStore->address) || $existingStore->address === 'Not specified') {
          $existingStore->address = $user->address ?? 'Not specified';
          $existingStore->address_url = $user->address ?? '';
        }
        $existingStore->save();

        return response()->json([
          'status' => true,
          'store' => $existingStore,
          'user' => $user->fresh(),
          'message' => 'Store already exists.',
        ], 200);
      }

      // Validate
      $validator = Validator::make($request->all(), [
        'category_id' => 'required|integer|exists:categories,id',
        'phone_number' => 'required|string|max:20',
        'city' => 'nullable|string|max:255',
        'wilaya' => 'nullable|string|max:255',
      ]);

      if ($validator->fails()) {
        return response()->json([
          'status' => false,
          'message' => 'Validation failed',
          'errors' => $validator->errors(),
        ], 422);
      }

      // ✅ CRITICAL FIX: Use user's profile image as store image
      $store = Store::create([
        'vendor_id' => $user->id,
        'category_id' => $request->category_id,
        'store_name' => $request->store_name ?? ($user->name),
        'phone_number' => $request->phone_number,
        'address' => $user->address ?? '',
        'address_url' => $user->address ?? '',
        'city' => $request->city,
        'wilaya' => $request->wilaya,
        'image' => $user->image,
        'logo' => $user->logo,
        'status' => 'active',
      ]);

      // Update user type to vendor
      $user->user_type = 'vendor';
      $user->save();

      return response()->json([
        'status' => true,
        'store' => $store,
        'user' => $user->fresh(),
        'message' => 'Store created and user promoted to vendor.',
      ], 201);

    } catch (\Exception $e) {
      \Log::error('AutoCreate Store Failed: ' . $e->getMessage());

      return response()->json([
        'status' => false,
        'message' => 'Failed to create store',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
}