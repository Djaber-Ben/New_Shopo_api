<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Wishlist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistApiController extends Controller
{
    /**
     * Display the authenticated user's wishlist.
     */
    public function index()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->with(['product' => function ($query) {
                $query->where('status', 'active')->with(['store']);
            }])
            ->get();

        return response()->json([
            'wishlist' => $wishlist,
        ], 200);
    }

    /**
     * Add a product to the authenticated user's wishlist.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if product is active
        $product = Product::where('id', $request->product_id)
            ->where('status', 'active')
            ->firstOrFail();

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Product already in wishlist',
            ], 409);
        }

        $wishlist = Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        $wishlist->load('product');

        return response()->json([
            'message' => 'Product added to wishlist',
            'wishlist' => $wishlist,
        ], 201);
    }

    /**
     * Remove a product from the authenticated user's wishlist.
     */
    public function destroy($product_id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product_id)
            ->firstOrFail();

        $wishlist->delete();

        return response()->json([
            'message' => 'Product removed from wishlist',
        ], 200);
    }
}
