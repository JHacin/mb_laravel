<?php

namespace Tests\Browser\Admin\Pages;

class AdminCatListPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.cats'));
    }
}
