<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Storage;

class CatPhotoController extends Controller
{
    const PATH_ROOT = 'muce/slike/';

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

        $path = self::PATH_ROOT . $filename;

        Storage::disk('public')->put($path, $image->stream());

        return response()->json([
            'filename' => $filename,
        ]);
    }

    /**
     * Remove a photo from the filesystem.
     *
     * @param string $filename
     *
     * @return string
     */
    public function delete(string $filename)
    {
        Storage::disk('public')->delete(self::PATH_ROOT . $filename);

        return 'OK';
    }
}
