<?php

namespace Tests\Browser\Pages;


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
