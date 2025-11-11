<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  // 🔹 Register Client
  public function registerClient(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|max:55',
      'email' => 'required|email|unique:users|min:3|max:60',
      'password' => 'required|min:6',
      'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'phone_number' => 'nullable|string|max:20',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'errors' => $validator->errors()
      ], 422);
    }

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'user_type' => 'client',
      'logo' => $request->hasFile('logo') ? $request->file('logo')->store('images/profiles/logos', 'public') : null,
      'image' => $request->hasFile('image') ? $request->file('image')->store('images/profiles/thumbnails', 'public') : null,
      'phone_number' => $request->phone_number,
    ]);

    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json([
      'status' => true,
      'message' => 'User registered successfully',
      'token' => $token,
      'user' => $user
    ], 201);
  }

  /**
   * Display the authenticated user's data.
   */
  public function edit($id)
  {
    if ($id != Auth::id()) {
      return response()->json(['message' => 'Unauthorized'], 403);
    }

    $user = User::findOrFail($id);

    return response()->json([
      'user' => $user->only([
        'id',
        'name',
        'email',
        'phone_number',
        'address',
        'user_type',
        'logo',
        'image'
      ]),
    ], 200);
  }

  /**
   * Update the authenticated user's data.
   */
  public function update(Request $request, $id)
  {
    if ($id != Auth::id()) {
      return response()->json(['message' => 'Unauthorized'], 403);
    }

    $user = User::findOrFail($id);

    // ✅ Validation
    $validator = Validator::make($request->all(), [
      'name' => 'sometimes|max:55',
      'email' => 'sometimes|email|unique:users,email,' . $id,
      'password' => 'sometimes|min:6|confirmed',
      'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'phone_number' => 'nullable|string|max:20',
      'address' => 'nullable|string|max:500',
      'city' => 'nullable|string|max:100',
      'wilaya' => 'nullable|string|max:100',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    // ✅ Prepare data for user update
    $data = $request->only([
      'name',
      'email',
      'phone_number',
      'address',
      'city',
      'wilaya'
    ]);

    // ✅ Handle password
    if ($request->filled('password')) {
      $data['password'] = Hash::make($request->password);
    }

    // ✅ Handle logo upload
    if ($request->hasFile('logo')) {
      if ($user->logo) {
        Storage::disk('public')->delete($user->logo);
      }
      $data['logo'] = $request->file('logo')->store('images/profiles/logos', 'public');
    } elseif ($request->has('logo') && $request->logo === null) {
      if ($user->logo) {
        Storage::disk('public')->delete($user->logo);
      }
      $data['logo'] = null;
    }

    // ✅ Handle image upload
    if ($request->hasFile('image')) {
      if ($user->image) {
        Storage::disk('public')->delete($user->image);
      }
      $data['image'] = $request->file('image')->store('images/profiles/thumbnails', 'public');
    } elseif ($request->has('image') && $request->image === null) {
      if ($user->image) {
        Storage::disk('public')->delete($user->image);
      }
      $data['image'] = null;
    }

    // ✅ Update user
    $user->update($data);

    // ✅ If vendor → sync their store too
    if ($user->user_type === 'vendor') {
      $store = \App\Models\Store::where('vendor_id', $user->id)->first();
      if ($store) {
        $store->store_name = $request->input('name', $store->store_name); 
        $store->city = $request->input('city', $store->city);
        $store->wilaya = $request->input('wilaya', $store->wilaya);
        $store->phone_number = $request->input('phone_number', $store->phone_number);

        // Copy image if updated
        if (isset($data['image'])) {
          $store->image = $data['image'];
        }

        // Address sync + coordinates
        if (!empty($request->address)) {
          $store->address = $request->address;
          $store->address_url = $request->address;

          $coords = app(\App\Http\Controllers\Api\StoreApiController::class)
            ->extractCoordinates($request->address);
          if ($coords) {
            $store->latitude = $coords['latitude'];
            $store->longitude = $coords['longitude'];
          }
        }

        $store->save();
      }
    }

    return response()->json([
      'message' => 'User and store updated successfully',
      'user' => $user->only([
        'id',
        'name',
        'email',
        'phone_number',
        'address',
        'city',
        'wilaya',
        'user_type',
        'logo',
        'image'
      ]),
    ], 200);
  }

  // 🔹 Login
  public function login(Request $request)
  {
    if (!Auth::attempt($request->only('email', 'password'))) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid email or password'
      ], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json([
      'status' => true,
      'message' => 'Login successful',
      'token' => $token,
      'user' => $user
    ]);
  }

  // 🔹 Logout
  public function logout(Request $request)
  {
    $request->user()->currentAccessToken()->delete();

    return response()->json([
      'status' => true,
      'message' => 'Logged out successfully'
    ]);
  }

  //Update user type (client to vendor)
  public function updateUserType(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'user_type' => 'required|in:client,vendor,admin',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Validation failed',
        'errors' => $validator->errors(),
      ], 422);
    }

    $user = $request->user();
    $user->user_type = $request->user_type;
    $user->save();

    return response()->json([
      'status' => true,
      'message' => 'User type updated successfully to ' . $request->user_type,
      'user' => $user->only([
        'id',
        'name',
        'email',
        'phone_number',
        'address',
        'user_type',
        'logo',
        'image'
      ]),
    ], 200);
  }
}