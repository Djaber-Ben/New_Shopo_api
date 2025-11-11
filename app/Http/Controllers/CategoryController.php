<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::latest();
        if(!empty($request->get('keyword'))){
            $categories = $categories->where('name', 'like', '%'.$request->get('keyword').'%');
        }
        
        $categories = $categories->paginate(10);
        // $data['category'] = $category;
        return view('admin.category.list', compact('categories'));
    }
    
    public function create(){
        return view('admin.category.create');
    }
    
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $path = $request->file('image')->store('images/categories', 'public');

        return response()->json([
            'status' => true,
            'file_path' => $path
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'status' => 'required',
            'show' => 'required',
            'image' => 'required|string', // comes from hidden input
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->show = $request->show;
        $category->image = $request->image; // path from hidden input
        $category->save();

        $request->session()->flash('success', 'تم إنشاء الفئة بنجاح.');

        return response()->json(['status' => true, 'message' => 'Category added successfully']);
    }
    
    public function edit($categoryId, Request $request){
        $category = Category::find($categoryId);
        if(empty($category)){
            return redirect()->route('categories.index');
        }
        return view('admin.category.edit', compact('category'));
    }
    
    public function update($categoryId, Request $request)
    {
        $category = Category::find($categoryId);

        if (empty($category)) {
            $request->session()->flash('error', 'Category Not Found');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category Not Found',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'status' => 'required',
            'show' => 'required',
            'image' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->show = $request->show;

        // ✅ If a new image is uploaded
        if ($request->filled('image') && $request->image !== $category->image) {
            // Delete old file if exists
            if (!empty($category->image) && Storage::disk('public')->exists($category->image)) {
                \Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->image; // save new path
        }

        $category->save();

        $request->session()->flash('success', 'تم تحديث الفئة بنجاح.');

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully'
        ]);
    }
    
    public function destroy($categoryId, Request $request){
        $category = Category::find($categoryId);
        if(empty($category)){
            $request->session()->flash('error', 'Category Not Found');
            return response()->json([
                'status' => true,
                'message' => 'Category Not Found',
            ]);
            // return redirect()->route('categories.index');
        }

        // File::delete(public_path().'/uploads/category/thump/'.$category->image);
        // File::delete(public_path().'/uploads/category/'.$category->image);

        if (!empty($category->image) && Storage::disk('public')->exists($category->image)) {
           \Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        $request->session()->flash('success', 'تم حذف الفئة بنجاح.');

        return response()->json([
            'status' => true,
            'message' => 'Category Deleted successfully',
        ]);
    }
}