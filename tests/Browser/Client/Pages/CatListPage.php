<?php

namespace Tests\Browser\Client\Pages;


class CatListPage extends Page
{
    /**
     * @return string
     */
    public function url(): string
    {
        return config('routes.cat_list');
    }
}
