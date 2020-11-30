<?php

namespace Tests\Browser\Pages\Admin;

use App\Models\PersonData;

class AdminPersonDataEditPage extends Page
{
    /**
     * @var PersonData|null
     */
    protected ?PersonData $personData = null;

    /**
     * @param PersonData $personData
     */
    public function __construct(PersonData $personData)
    {
        $this->personData = $personData;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return str_replace('{id}', $this->personData->id, $this->prefixUrl(config('routes.admin.person_data_edit')));
    }
}
