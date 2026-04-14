<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();

        return view('admin.sliders.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sliders.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'sub_title' => 'nullable',
            'title' => 'required',
            'highlight_word' => 'nullable',
            'description' => 'nullable',
            'button_text' => 'nullable',
            'button_link' => 'nullable',
            'video_url' => 'nullable',
            'image' => 'required'
        ]);

        Slider::create($data);

        return redirect()->route('admin.sliders.index')
            ->with('success','Slider Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.form',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title'=>'required',
            'image'=>'required'
        ]);

        $slider->update([
            'sub_title' => $request->sub_title,
            'title' => $request->title,
            'highlight_word' => $request->highlight_word,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'video_url' => $request->video_url,
            'image' => $request->image,
            'order' => $request->order ?? 0,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.sliders.index')
        ->with('success','Slider Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();

        return redirect()->route('admin.sliders.index')
        ->with('success','Slider Deleted');
    }
}
