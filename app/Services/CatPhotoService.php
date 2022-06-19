<?php

namespace App\Services;

use App\Models\Cat;
use App\Models\CatPhoto;
use Illuminate\Support\Str;
use Image;
use JetBrains\PhpStorm\Pure;
use Storage;

class CatPhotoService
{
    const PATH_ROOT = 'muce/slike';

    const INDICES = [0, 1, 2, 3];

    public static function getPlaceholderImage(): string
    {
        return asset('img/placeholder.png');
    }

    #[Pure]
    public static function isBase64ImageString(string $string): bool
    {
        return Str::startsWith($string, 'data:image');
    }

    public function create(Cat $cat, string $imageBase64, int $index): CatPhoto
    {
        $filename = $this->createImageFromBase64($imageBase64);
        $photo = $this->associate($cat, $filename, $index);
        return $photo;
    }

    private function createImageFromBase64(string $base64): string
    {
        $image = Image::make($base64)
            ->widen(1600, function ($constraint) {
                $constraint->upsize();
            })
            ->encode('jpg')
            ->stream('jpg', 60);

        $filename = md5($base64 . time()) . '.jpg';

        $this->storeToDisk($filename, $image);

        return $filename;
    }

    private function associate(Cat $cat, string $filename, int $index): CatPhoto
    {
        $photo = new CatPhoto;
        $photo->cat_id = $cat->id;
        $photo->filename = $filename;
        $photo->index = $index;
        $photo->save();
        return $photo;
    }

    private function storeToDisk(string $filename, $contents)
    {
        Storage::disk('public')->put(CatPhotoService::getFullPath($filename), $contents);
    }

    public static function getFullPath(string $filename): string
    {
        return self::PATH_ROOT . '/' . $filename;
    }

    public function deleteFromDisk(string $filename)
    {
        Storage::disk('public')->delete(self::getFullPath($filename));
    }
}
