<?php

namespace Tests\Browser\Pages\Admin;

use App\Models\CatLocation;

class AdminCatLocationEditPage extends Page
{
    /**
     * @var CatLocation|null
     */
    protected ?CatLocation $catLocation = null;

    /**
     * @param CatLocation $catLocation
     */
    public function __construct(CatLocation $catLocation)
    {
        $this->catLocation = $catLocation;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return str_replace('{id}', $this->catLocation->id, $this->prefixUrl(config('routes.admin.cat_locations_edit')));
    }
}
