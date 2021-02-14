<?php

namespace Tests\Browser\Admin\Pages;

class AdminCatAddPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.cats_add'));
    }
}
