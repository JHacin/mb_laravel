<?php

namespace Tests\Browser\Admin\Pages;

use App\Models\Sponsorship;

class AdminSponsorshipEditPage extends Page
{
    protected Sponsorship $sponsorship;

    public function __construct(Sponsorship $sponsorship)
    {
        $this->sponsorship = $sponsorship;
    }

    public function url(): string
    {
        return str_replace('{id}', $this->sponsorship->id, $this->prefixUrl(config('routes.admin.sponsorships_edit')));
    }
}
