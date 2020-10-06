<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $image = $request->file('image');

        //Todo: return err if $image->isValid() is false

        $name = time() . '_' . $image->getClientOriginalName();
        $path = $image->storeAs('muce/slike', $name, 'public');

        return response()->json([
            'name' => $name,
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
