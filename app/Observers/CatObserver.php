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
     * Handle the cat "created" event.
     *
     * @param Cat $cat
     * @return void
     */
    public function created(Cat $cat)
    {
        //
    }

    /**
     * Handle the cat "updated" event.
     *
     * @param Cat $cat
     * @return void
     */
    public function updated(Cat $cat)
    {
        //
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

    /**
     * Handle the cat "deleted" event.
     *
     * @param Cat $cat
     * @return void
     * @throws Exception
     */
    public function deleted(Cat $cat)
    {
        //
    }

    /**
     * Handle the cat "restored" event.
     *
     * @param Cat $cat
     * @return void
     */
    public function restored(Cat $cat)
    {
        //
    }

    /**
     * Handle the cat "force deleted" event.
     *
     * @param Cat $cat
     * @return void
     */
    public function forceDeleted(Cat $cat)
    {
        //
    }
}
