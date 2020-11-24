<?php

namespace Tests\Traits;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

trait CreatesFakeStorage
{
    /**
     * @return Filesystem|FilesystemAdapter
     */
    protected function createFakeStorage()
    {
        Storage::fake('public');
        return $this->getFakeStorage();
    }

    /**
     * @return Filesystem|FilesystemAdapter
     */
    protected function getFakeStorage()
    {
        return Storage::disk('public');
    }
}
