<?php

namespace Tests\Unit\Utilities;

use App\Utilities\BankTransferFieldGenerator;
use Tests\TestCase;

class BankTransferFieldGeneratorTest extends TestCase
{
    public function test_generates_correct_purpose()
    {
        $cat = $this->createCat(['name' => 'muca']);
        $sponsorship = $this->createSponsorship(['cat_id' => $cat->id]);
        $this->assertEquals(
            'BOTER-MUCA-' . $sponsorship->cat_id,
            BankTransferFieldGenerator::purpose($sponsorship)
        );

        $cat = $this->createCat(['name' => 'muca s presledki']);
        $sponsorship = $this->createSponsorship(['cat_id' => $cat->id]);
        $this->assertEquals(
            'BOTER-MUCA-S-PRESLEDKI-' . $sponsorship->cat_id,
            BankTransferFieldGenerator::purpose($sponsorship)
        );

        $cat = $this->createCat(['name' => 'muca čšž']);
        $sponsorship = $this->createSponsorship(['cat_id' => $cat->id]);
        $this->assertEquals(
            'BOTER-MUCA-ČŠŽ-' . $sponsorship->cat_id,
            BankTransferFieldGenerator::purpose($sponsorship)
        );
    }

    public function test_generates_correct_reference_number()
    {
        $sponsorship = $this->createSponsorship();

        $this->assertEquals(
            sprintf('SI00 80-%s-%s', $sponsorship->cat_id, $sponsorship->person_data_id),
            BankTransferFieldGenerator::referenceNumber($sponsorship)
        );
    }
}
