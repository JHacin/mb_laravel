<?php

namespace Tests\Browser\Pages\Admin;

use Tests\Browser\Pages\Page as BasePage;

abstract class Page extends BasePage
{
    /**
     * @param string $url
     * @return string
     */
    protected function prefixUrl(string $url)
    {
        return '/' . config('backpack.base.route_prefix') . '/' . $url;
    }
}
