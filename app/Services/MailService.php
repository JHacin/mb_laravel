<?php

namespace App\Services;

use Exception;

class MailService
{

    /**
     * @var string[]
     */
    protected $bccCopyAddress = [];

    /**
     * MailService constructor.
     */
    public function __construct()
    {
        $this->bccCopyAddress = env('MAIL_BCC_COPY_ADDRESS', []);
    }

    protected function logException(Exception $e)
    {
        // Todo: implement logging
    }
}
