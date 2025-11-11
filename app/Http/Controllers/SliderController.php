<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    public function index(Request $request){
        $sliders = Slider::latest();
        if(!empty($request->get('keyword'))){
            $sliders = $sliders->where('title', 'like', '%'.$request->get('keyword').'%');
        }
        
        $sliders = $sliders->paginate(10);
        return view('admin.Slider.list', compact('sliders'));
    }
    
    public function create(){
        return view('admin.Slider.create');
    }
    
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $path = $request->file('image')->store('images/sliders', 'public');

        return response()->json([
            'status' => true,
            'file_path' => $path
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:sliders,title',
            'link' => 'nullable',
            'status' => 'required',
            'image' => 'required|string', // comes from hidden input
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $Slider = new Slider();
        $Slider->title = $request->title;
        $Slider->link = $request->link;
        $Slider->status = $request->status;
        $Slider->slider_image = $request->image; // path from hidden input
        $Slider->save();

        $request->session()->flash('success', 'تم إنشاء شريط التمرير بنجاح.');

        return response()->json(['status' => true, 'message' => 'Slider added successfully']);
    }
    
    public function edit($SliderId, Request $request){
        $Slider = Slider::find($SliderId);
        if(empty($Slider)){
            return redirect()->route('sliders.index');
        }
        return view('admin.Slider.edit', compact('Slider'));
    }
    
    public function update($SliderId, Request $request)
    {
        $Slider = Slider::find($SliderId);

        if (empty($Slider)) {
            $request->session()->flash('error', 'Slider Not Found');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Slider Not Found',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:sliders,title,' . $Slider->id,
            'link' => 'nullable',
            'status' => 'required',
            'image' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $Slider->title = $request->title;
        $Slider->link = $request->link;
        $Slider->status = $request->status;

        // ✅ If a new image is uploaded
        if ($request->filled('image') && $request->image !== $Slider->slider_image) {
            // Delete old file if exists
            if (!empty($Slider->slider_image) && Storage::disk('public')->exists($Slider->slider_image)) {
                Storage::disk('public')->delete($Slider->slider_image);
            }
            $Slider->slider_image = $request->image; // save new path
        }

        $Slider->save();

        $request->session()->flash('success', 'تم تحديث شريط التمرير بنجاح.');

        return response()->json([
            'status' => true,
            'message' => 'Slider updated successfully'
        ]);
    }
    
    public function destroy($SliderId, Request $request){
        $Slider = Slider::find($SliderId);
        if(empty($Slider)){
            $request->session()->flash('error', 'Slider Not Found');
            return response()->json([
                'status' => true,
                'message' => 'Slider Not Found',
            ]);
            return redirect()->route('sliders.index');
        }

        if (!empty($Slider->slider_image) && Storage::disk('public')->exists($Slider->slider_image)) {
           \Storage::disk('public')->delete($Slider->slider_image);
        }

        $Slider->delete();
        $request->session()->flash('success', 'تم حذف شريط التمرير بنجاح.');

        return response()->json([
            'status' => true,
            'message' => 'Slider Deleted successfully',
        ]);
    }
}