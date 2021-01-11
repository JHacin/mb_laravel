<?php

namespace Tests\Traits;

use App\Models\SponsorshipMessageType;

trait CreatesSponsorshipMessageTypes
{
    protected function createSponsorshipMessageType($attributes = []): SponsorshipMessageType
    {
        /** @var SponsorshipMessageType $messageType */
        $messageType = SponsorshipMessageType::factory()->createOne($attributes);
        return $messageType;
    }
}
