<?php

namespace Tests\Browser\Pages\Admin;

use App\Models\Sponsorship;

class AdminSponsorshipEditPage extends Page
{
    /**
     * @var Sponsorship|null
     */
    protected Sponsorship $sponsorship;

    /**
     * @param Sponsorship $sponsorship
     */
    public function __construct(Sponsorship $sponsorship)
    {
        $this->sponsorship = $sponsorship;
    }

    /**
     * @return string
     */
    public function url()
    {
        return str_replace('{id}', $this->sponsorship->id, $this->prefixUrl(config('routes.admin.sponsorships_edit')));
    }
}
