<?php

namespace Tests\Browser\Pages\Admin;

class AdminPersonDataAddPage extends Page
{
    /**
     * @return string
     */
    public function url()
    {
        return $this->prefixUrl(config('routes.admin.person_data_add'));
    }
}
