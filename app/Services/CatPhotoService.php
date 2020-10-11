<?php

namespace App\Services;

use App\Models\Cat;
use App\Models\CatPhoto;
use Illuminate\Support\Str;
use Image;
use Storage;

class CatPhotoService
{
    const PATH_ROOT = 'muce/slike/';

    /**
     * Return the full path relative to the public storage root.
     *
     * @param string $filename
     *
     * @return string
     */
    public static function getFullPath(string $filename)
    {
        return self::PATH_ROOT . $filename;
    }

    /**
     * Check if the provided is a base64-encoded image string.
     * This is used e.g. to determine if the photo_n field in the request contains an existing image path
     * or a new image (encoded as base64).
     *
     * @param string $string
     *
     * @return bool
     */
    public static function isBase64ImageString(string $string)
    {
        return Str::startsWith($string, 'data:image');
    }

    /**
     * Convert a base64 string to an image, store it and return its filename
     * relative to PATH_ROOT.
     *
     * @param string $base64
     *
     * @return string
     */
    public function createImageFromBase64(string $base64)
    {
        $image = Image::make($base64)->encode('jpg', 90);

        $filename = md5($base64 . time()) . '.jpg';

        Storage::disk('public')->put(CatPhotoService::getFullPath($filename), $image->stream());

        return $filename;
    }

    /**
     * Create and connect a new CatPhoto model.
     *
     * @param Cat $cat
     * @param string $filename
     * @param int $index
     *
     * @return void
     */
    public function create(Cat $cat, string $filename, int $index)
    {
        $photo = new CatPhoto;
        $photo->cat_id = $cat->id;
        $photo->filename = $filename;
        $photo->index = $index;
        $photo->save();
    }

    /**
     * Remove a photo from the filesystem.
     *
     * @param string $filename
     *
     * @return void
     */
    public function deleteFromDisk(string $filename)
    {
        Storage::disk('public')->delete(self::getFullPath($filename));
    }
}
