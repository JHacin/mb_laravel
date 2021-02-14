<?php

namespace Tests\Browser\Admin\Pages;

class AdminCatLocationListPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.cat_locations'));
    }
}
