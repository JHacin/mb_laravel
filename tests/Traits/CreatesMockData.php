<?php

namespace Tests\Traits;

trait CreatesMockData
{
    use CreatesUsers, CreatesPersonData, CreatesCats, CreatesCatPhotos, CreatesFakeStorage;
}
