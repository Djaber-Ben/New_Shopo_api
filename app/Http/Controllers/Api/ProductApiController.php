<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use App\Models\Images;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
  /**
   * Display all products of the store.
   */
  public function index(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'store_id' => 'nullable|exists:stores,id',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Invalid store ID',
        'errors' => $validator->errors(),
      ], 422);
    }

    $query = Product::with(['store', 'images']);

    $storeId = $request->query('store_id');
    if (!empty($storeId)) {
      $query->where('store_id', $storeId);
    }

    $products = $query->where('status', 'active')->paginate(20);

    return response()->json([
      'products' => $products->items(),
      'pagination' => [
        'total' => $products->total(),
        'per_page' => $products->perPage(),
        'current_page' => $products->currentPage(),
        'last_page' => $products->lastPage(),
      ],
    ]);
  }

  /**
   * Return data needed to create a new product.
   */
  public function create()
  {
    $user = Auth::user();
    $stores = Store::where('vendor_id', $user->id)
      ->where('status', 'active')
      ->get();

    return response()->json([
      'user' => $user,
      'stores' => $stores,
    ], 200);
  }

  /**
   * Store a newly created product in the database.
   */
  public function store(Request $request)
  {
    \Log::info('=== PRODUCT CREATE START ===');
    \Log::info('Has images:', ['hasFile' => $request->hasFile('images')]);

    // Validate the request
    $validator = Validator::make($request->all(), [
      'store_id' => 'required|exists:stores,id',
      'title' => 'required|string|max:255',
      'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:1500',
      'description' => 'nullable|string',
      'price' => 'required|numeric|min:0',
      'track_qty' => 'required|in:yes,no',
      'status' => 'required|in:active,inactive,out_of_stock',
      'condition' => 'nullable|string',
    ]);

    if ($validator->fails()) {
      \Log::error('Validation failed:', $validator->errors()->toArray());
      return response()->json(['errors' => $validator->errors()], 422);
    }

    //store belongs to the authenticated vendor
    $store = Store::where('id', $request->store_id)
      ->where('vendor_id', Auth::id())
      ->firstOrFail();

    // Storing the main image
    $mainImagePath = null;
    if ($request->hasFile('images')) {
      $images = $request->file('images');
      
      // Handle single or multiple files
      if (!is_array($images)) {
        $images = [$images];
      }

      if (count($images) > 0 && $images[0] != null) {
        try {
          $mainImagePath = $images[0]->store('images/products/main', 'public');
          \Log::info('✅ Main image saved:', ['path' => $mainImagePath]);
        } catch (\Exception $e) {
          \Log::error('❌ Main image failed:', ['error' => $e->getMessage()]);
        }
      }
    }

    // Create the product
    $product = Product::create([
      'store_id' => $request->store_id,
      'title' => $request->title,
      'image' => $mainImagePath,
      'description' => $request->description ?? '',
      'price' => $request->price,
      'qty' => $request->qty ?? 0,
      'track_qty' => $request->track_qty,
      'status' => $request->status,
      'condition' => $request->condition ?? 'Not specified',
    ]);

    \Log::info('✅ Product created:', ['id' => $product->id, 'title' => $product->title]);

    // Save sub-images 
    if ($request->hasFile('images')) {
      $images = $request->file('images');
      
      if (!is_array($images)) {
        $images = [$images];
      }

      \Log::info('📸 Total images received:', ['count' => count($images)]);

      for ($i = 1; $i < count($images); $i++) {
        $file = $images[$i];

        if (!$file) {
          \Log::warning("⚠️ Image at index $i is null");
          continue;
        }

        if (!$file->isValid()) {
          \Log::warning("⚠️ Image at index $i failed validation", [
            'error' => $file->getError(),
            'errorMessage' => $file->getErrorMessage()
          ]);
          continue;
        }

        try {
          $filename = time() . '_' . uniqid() . '_' . $i . '.' . $file->getClientOriginalExtension();
          $subPath = $file->storeAs('images/products/sub', $filename, 'public');

          \Log::info("📤 Storing sub-image $i:", [
            'original_name' => $file->getClientOriginalName(),
            'stored_path' => $subPath,
            'file_size' => $file->getSize()
          ]);

          if ($subPath) {
            $imageRecord = Images::create([
              'product_id' => $product->id,
              'image' => $subPath,
              'is_primary' => false,
            ]);
            \Log::info("✅ Sub-image $i saved to DB:", [
              'id' => $imageRecord->id,
              'path' => $subPath
            ]);
          } else {
            \Log::error("❌ storeAs() returned NULL for image $i");
          }
        } catch (\Exception $e) {
          \Log::error("❌ Error saving image $i:", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
          ]);
        }
      }
    }

    $product->load('images');

    \Log::info('=== PRODUCT CREATE END ===', [
      'product_id' => $product->id,
      'images_count' => count($product->images)
    ]);

    return response()->json([
      'message' => 'Product created successfully',
      'product' => $product,
    ], 201);
  }

  /**
   * Displaying spesified product only for the store owner.
   */
  public function edit($id)
  {
    $product = Product::whereHas('store', function ($query) {
      $query->where('vendor_id', Auth::id());
    })
      ->with('images')
      ->findOrFail($id);

    return response()->json(['product' => $product], 200);
  }

  /**
   * Displaying the specified product to all users.
   */
  public function show($id)
  {
    $product = Product::with('store')->with('images')->findOrFail($id);
    return response()->json(['product' => $product], 200);
  }

  /**
   * Updating the specified product in the database.
   */
  public function update(Request $request, $id)
  {
    $product = Product::whereHas('store', function ($query) {
      $query->where('vendor_id', Auth::id());
    })->findOrFail($id);

    $validator = Validator::make($request->all(), [
      'store_id' => 'sometimes|exists:stores,id',
      'title' => 'sometimes|string|max:255',
      'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:1500',
      'description' => 'nullable|string',
      'price' => 'sometimes|numeric|min:0',
      'track_qty' => 'sometimes|in:yes,no',
      'status' => 'sometimes|in:active,inactive,out_of_stock',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    if ($request->has('store_id')) {
      Store::where('id', $request->store_id)
        ->where('vendor_id', Auth::id())
        ->firstOrFail();
    }

    $data = $request->only([
      'store_id',
      'title',
      'description',
      'price',
      'qty',
      'track_qty',
      'status'
    ]);

    $product->update($data);
    $product->load('images');

    return response()->json([
      'message' => 'Product updated successfully',
      'product' => $product,
    ], 200);
  }

  /**
   * Removing the specified product from the database.
   */
  public function destroy($id)
  {
    $product = Product::whereHas('store', function ($query) {
      $query->where('vendor_id', Auth::id());
    })->findOrFail($id);

    if ($product->image) {
      Storage::disk('public')->delete($product->image);
    }

    $product->delete();

    return response()->json(['message' => 'Product deleted successfully'], 200);
  }
}