<?php

namespace Tests\Browser\Pages\Admin;

class AdminCatLocationAddPage extends Page
{
    /**
     * @return string
     */
    public function url()
    {
        return $this->prefixUrl(config('routes.admin.cat_locations_add'));
    }
}
