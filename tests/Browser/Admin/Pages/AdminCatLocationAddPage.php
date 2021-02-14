<?php

namespace Tests\Browser\Admin\Pages;

class AdminCatLocationAddPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.cat_locations_add'));
    }
}
