<?php

namespace Tests\Browser\Pages\Admin;

class AdminCatListPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.cats'));
    }
}
