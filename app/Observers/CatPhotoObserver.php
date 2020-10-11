<?php

namespace App\Observers;

use App\Models\CatPhoto;
use App\Services\CatPhotoService;

class CatPhotoObserver
{
    /**
     * @var CatPhotoService
     */
    private $catPhotoService;

    /**
     * CatPhotoObserver constructor.
     */
    public function __construct()
    {
        $this->catPhotoService = new CatPhotoService();
    }


    /**
     * Handle the cat photo "created" event.
     *
     * @param CatPhoto $catPhoto
     * @return void
     */
    public function created(CatPhoto $catPhoto)
    {
        //
    }

    /**
     * Handle the cat photo "updated" event.
     *
     * @param CatPhoto $catPhoto
     * @return void
     */
    public function updated(CatPhoto $catPhoto)
    {
        //
    }

    /**
     * Handle the cat photo "deleted" event.
     *
     * @param CatPhoto $catPhoto
     * @return void
     */
    public function deleted(CatPhoto $catPhoto)
    {
        $this->catPhotoService->deleteFromDisk($catPhoto->filename);
    }

    /**
     * Handle the cat photo "restored" event.
     *
     * @param CatPhoto $catPhoto
     * @return void
     */
    public function restored(CatPhoto $catPhoto)
    {
        //
    }

    /**
     * Handle the cat photo "force deleted" event.
     *
     * @param CatPhoto $catPhoto
     * @return void
     */
    public function forceDeleted(CatPhoto $catPhoto)
    {
        //
    }
}
