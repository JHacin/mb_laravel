<?php

namespace Tests\Unit;

use App\Models\PersonData;
use App\Utilities\SponsorListViewParser;
use Tests\TestCase;

class SponsorListViewParserTest extends TestCase
{

    /**
     * @return void
     */
    public function test_parses_sponsor_data_for_view_correctly()
    {
        $anonymous = [
            $this->createSponsorship([
                'is_anonymous' => false,
                'person_data_id' => PersonData::factory()->createOne([
                    'first_name' => null,
                    'city' => null,
                ])
            ]),
            $this->createSponsorship([
                'is_anonymous' => true,
                'person_data_id' => PersonData::factory()->createOne([
                    'first_name' => 'Miško',
                    'city' => null,
                ])
            ]),
            $this->createSponsorship([
                'is_anonymous' => true,
                'person_data_id' => PersonData::factory()->createOne([
                    'first_name' => null,
                    'city' => null,
                ])
            ]),
            $this->createSponsorship([
                'is_anonymous' => true,
                'person_data_id' => PersonData::factory()->createOne([
                    'first_name' => null,
                    'city' => 'Celje',
                ])
            ]),
        ];

        $identified = [
            $this->createSponsorship([
                'is_anonymous' => false,
                'person_data_id' => PersonData::factory()->createOne([
                    'first_name' => null,
                    'city' => 'Celje',
                ])
            ]),

            $this->createSponsorship([
                'is_anonymous' => false,
                'person_data_id' => PersonData::factory()->createOne([
                    'first_name' => 'Miško',
                    'city' => null,
                ])
            ]),
        ];

        $viewData = SponsorListViewParser::prepareViewData(array_merge($anonymous, $identified));

        $this->assertCount(4, $viewData['anonymous']);
        $this->assertCount(2, $viewData['identified']);
        $this->assertEquals('4 anonimni botri', $viewData['anonymous_count_label']);
    }

    /**
     * @return void
     */
    public function test_handles_empty_array()
    {
        $viewData = SponsorListViewParser::prepareViewData([]);

        $this->assertCount(0, $viewData['anonymous']);
        $this->assertCount(0, $viewData['identified']);
        $this->assertEquals('0 anonimnih botrov', $viewData['anonymous_count_label']);
    }
}
