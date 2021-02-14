<?php

namespace Tests\Browser\Admin\Pages;

use App\Models\PersonData;

class AdminSponsorEditPage extends Page
{
    protected ?PersonData $personData = null;

    public function __construct(PersonData $personData)
    {
        $this->personData = $personData;
    }

    public function url(): string
    {
        return str_replace('{id}', $this->personData->id, $this->prefixUrl(config('routes.admin.sponsors_edit')));
    }
}
