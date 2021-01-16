<?php

namespace Tests\Traits;

use App\Models\SponsorshipMessage;

trait CreatesSponsorshipMessages
{
    protected function createSponsorshipMessage($attributes = []): SponsorshipMessage
    {
        /** @var SponsorshipMessage $messageType */
        $messageType = SponsorshipMessage::factory()->createOne($attributes);
        return $messageType;
    }
}
