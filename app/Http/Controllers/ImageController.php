<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $attachment = $request->file('file');
        $getName = $attachment->getClientOriginalName();
        $array = explode('.', $getName);
        $extension = end($array);
        $attachmentName = time().$attachment->getClientOriginalName();

        $originalImage  = $request->file('file');
        $thumbnailImage = \Intervention\Image\Laravel\Facades\Image::read($originalImage->getRealPath());
        // $thumbnailPath  = public_path().'/thumbnail/';
        $originalPath   = public_path().'/thumb/';
        // $thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
        // $thumbnailImage->resize(500,500);
        $thumbnailImage->contain(1000, 1000, 'FAF9F6');
        // $thumbnailImage->save($thumbnailPath.time().$originalImage->getClientOriginalName());
        $attachmentWithThumbPath = '/thumb'.'/'.time().$originalImage->getClientOriginalName();
        $thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
        $upload_success = $attachment->move(public_path('images/attachment/'),$attachmentName);
        $request['fileName'] = $attachmentName;

        $attachmentWithPath = 'images/attachment/'.$attachmentName;
        $fileName = pathinfo($getName, PATHINFO_FILENAME);
        // Thumbnil images
//        $attachment = new Image();
//        $attachment->guest_id = $id;
//        $attachment->fileName = $fileName;
//        $attachment->filePath = $attachmentWithThumbPath;
//        $attachment->type = $extension;
//        $attachment->save();

        if ($upload_success) {
            return response()->json($upload_success, 200);
        }
        // Else, return error 400
        else {
            return response()->json('error', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }

    public function storeImages(Request $request, $id)
    {
        $attachment = $request->file('file');
        $getName = $attachment->getClientOriginalName();
        $array = explode('.', $getName);
        $extension = end($array);
        $attachmentName = time().$attachment->getClientOriginalName();

        $originalImage  = $request->file('file');
        $thumbnailImage = \Intervention\Image\Laravel\Facades\Image::read($originalImage->getRealPath());
        // $thumbnailPath  = public_path().'/thumbnail/';
        $originalPath   = public_path().'/thumb/';
        // $thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
        // $thumbnailImage->resize(500,500);
        $thumbnailImage->contain(1000, 1000, 'FAF9F6');
        // $thumbnailImage->save($thumbnailPath.time().$originalImage->getClientOriginalName());
        $attachmentWithThumbPath = '/thumb'.'/'.time().$originalImage->getClientOriginalName();
        $thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
        $upload_success = $attachment->move(public_path('images/attachment/'),$attachmentName);
        $request['fileName'] = $attachmentName;

        $attachmentWithPath = 'images/attachment/'.$attachmentName;
        $fileName = pathinfo($getName, PATHINFO_FILENAME);
        // Thumbnil images
        $attachment = new Image();
        $attachment->patient_id = $id;
        $attachment->fileName = $fileName;
        $attachment->filePath = $attachmentWithThumbPath;
        $attachment->type = $extension;
        $attachment->save();

        if ($upload_success) {
            return response()->json($upload_success, 200);
        }
        // Else, return error 400
        else {
            return response()->json('error', 400);
        }

    }
}
