<?php

namespace App\Observers;

use App\Models\Cat;
use App\Services\CatPhotoService;
use Exception;

class CatObserver
{
    /**
     * @var CatPhotoService
     */
    private $catPhotoService;

    /**
     * CatObserver constructor.
     */
    public function __construct()
    {
        $this->catPhotoService = new CatPhotoService();
    }

    /**
     * Handle the cat "deleting" event.
     *
     * @param Cat $cat
     * @return void
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
