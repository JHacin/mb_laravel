<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Storage;

class CatPhotoController extends Controller
{
    /**
     * Store a photo in the filesystem and return its ID.
     *
     * @param Request $request
     *
     * @return string
     */
    public function upload(Request $request)
    {
        $base64 = $request->get('photo_base64');
        // Todo: throw if missing or not valid base64

        $image = Image::make($base64)->encode('jpg', 90);

        $filename = md5($base64 . time()) . '.jpg';

        $path = 'muce/slike/' . $filename;

        Storage::disk('public')->put($path, $image->stream());

        return response()->json([
            'name' => $filename,
            'path' => $path,
        ]);
    }

    /**
     * Remove a photo from the filesystem.
     *
     * @param string $name
     *
     * @return string
     */
    public function delete(string $name)
    {
        Storage::disk('public')->delete('muce/slike/' . $name);

        return 'OK';
    }
}
