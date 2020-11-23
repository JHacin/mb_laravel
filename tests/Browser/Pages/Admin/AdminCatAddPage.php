<?php

namespace Tests\Browser\Pages\Admin;

class AdminCatAddPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return $this->prefixUrl(config('routes.admin.cats_add'));
    }
}
