<?php

namespace App\Observers;

use App\Models\CatPhoto;
use App\Services\CatPhotoService;

class CatPhotoObserver
{
    private CatPhotoService $catPhotoService;

    public function __construct()
    {
        $this->catPhotoService = new CatPhotoService();
    }

    public function deleted(CatPhoto $catPhoto)
    {
        $this->catPhotoService->deleteFromDisk($catPhoto->filename);
    }
}
