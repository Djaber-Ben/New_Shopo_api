<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'active')
            ->where('show', true)
            ->get();

        $categories->transform(function ($category) {
            if ($category->image && !str_starts_with($category->image, 'storage/')) {
                $category->image = 'storage/' . $category->image;
            }
            return $category;
        });

        return response()->json($categories, 200);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        if ($category->image && !str_starts_with($category->image, 'storage/')) {
            $category->image = 'storage/' . $category->image;
        }

        return response()->json($category, 200);
    }
}
