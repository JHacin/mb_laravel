<?php

namespace App\Observers;

use App\Models\Cat;
use App\Services\CatPhotoService;
use Exception;

class CatObserver
{
    private CatPhotoService $catPhotoService;

    public function __construct()
    {
        $this->catPhotoService = new CatPhotoService();
    }

    /**
     * @throws Exception
     */
    public function deleting(Cat $cat)
    {
        foreach ($cat->photos as $photo) {
            $this->catPhotoService->deleteFromDisk($photo->filename);
            $photo->delete();
        }
    }
}
