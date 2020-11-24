<?php

namespace Tests\Traits;

trait CreatesMockData
{
    use
        CreatesFakeStorage,
        CreatesUsers,
        CreatesPersonData,
        CreatesCats,
        CreatesCatPhotos,
        CreatesCatLocations,
        CreatesSponsorships;
}
