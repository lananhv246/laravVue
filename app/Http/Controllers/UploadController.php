<?php

namespace App\Http\Controllers;

use File;
use Auth;
use Image;
use Illuminate\Support\Facades\Input;
use App\Upload;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        # id user login
        $id = Auth::id();
        $this->validate($request, [
            'image' => 'required'
        ]);
        $image = $request->image;
        $fileName = $request->file['name'];
        $fileSize = $request->file['size'];
        $fileType = $request->file['type'];
        if($image) {
            $fullsize = public_path('image/');
            $thumbnail = public_path('image/thumbnail/');
            if(!File::isDirectory($fullsize)) {
                File::makeDirectory($fullsize, 0777, true, true);
            }
            
            if(!File::isDirectory($thumbnail)) {
                File::makeDirectory($thumbnail, 0777, true, true);
            }
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $img = Image::make($image);
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnail.'/thumbnail_'. time() . '_' . $fileName);
            \Image::make($image)->save($fullsize. time() . '_' . $fileName);

        }
        $image = new Upload();
        if($fileSize) {
            $image->size = $fileSize;
        }
        if($fileType) {
            $image->type = $fileType;
        }
        $image->userId = $id;
        $image->fileName = time() . '_' . $fileName;
        $image->path = 'image/'.$image->fileName;
        $image->save();
        return response()->json($image, Response::HTTP_OK);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function show(upload $upload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function edit(upload $upload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, upload $upload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(upload $upload)
    {
        //
    }
}
