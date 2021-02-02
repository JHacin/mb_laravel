<?php

namespace Tests\Browser\Pages\Admin;

class AdminCatAddPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.cats_add'));
    }
}
