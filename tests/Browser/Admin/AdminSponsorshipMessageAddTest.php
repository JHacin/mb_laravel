<?php

namespace Tests\Browser\Admin;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\SponsorshipMessageType;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorshipMessageAddPage;
use Tests\Browser\Pages\Admin\AdminSponsorshipMessageListPage;
use Throwable;

class AdminSponsorshipMessageAddTest extends AdminTestCase
{

    /**
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $this->disableHtmlFormValidation($b);
            $this->clickSubmitButton($b);
            $this->assertAllRequiredErrorsAreShown($b, [
                '@cat-wrapper',
                '@personData-wrapper',
                '@messageType-wrapper',
                '@should_send_email-input-wrapper',
            ]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_selects_have_the_right_options()
    {
        $this->browse(function (Browser $b) {
            $activeTypes = SponsorshipMessageType::where('is_active', true);
            $inactiveType = $this->createSponsorshipMessageType(['is_active' => false]);
            $this->goToPage($b);

            $b->assertSelectHasOptions('messageType', $activeTypes->pluck('id')->toArray());
            $b->assertSelectMissingOptions('messageType', [$inactiveType->id]);
            $b->assertSelectHasOptions('personData', PersonData::pluck('id')->toArray());
            $b->assertSelectHasOptions('cat', Cat::pluck('id')->toArray());
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_list_of_messages_sent_to_sponsor()
    {
        $this->browse(function (Browser $b) {
            $withMessages = $this->createPersonData();
            $sentMessage = $this->createSponsorshipMessage(['person_data_id' => $withMessages->id]);
            $withoutMessages = $this->createPersonData();
            $this->goToPage($b);

            // Initial state
            $b->assertVisible('@sent-messages-none-selected-msg');
            $b->assertMissing('@sent-messages-loader');
            $b->assertMissing('@sent-messages-table-wrapper');
            $b->assertMissing('@sent-messages-already-sent-warning');

            // Loading
            $b->select('personData', $withMessages->id);
            $b->assertMissing('@sent-messages-none-selected-msg');
            $b->assertVisible('@sent-messages-loader');
            $b->assertMissing('@sent-messages-table-wrapper');
            $b->assertMissing('@sent-messages-already-sent-warning');

            $this->waitForRequestsToFinish($b);
            // Table is visible
            $b->assertMissing('@sent-messages-none-selected-msg');
            $b->assertMissing('@sent-messages-loader');
            $b->assertVisible('@sent-messages-table-wrapper');
            $b->assertMissing('@sent-messages-already-sent-warning');

            // Shows which messages were sent
            foreach (SponsorshipMessageType::all() as $messageType) {
                $rowSelector = '.sent-message-row[data-message-type-id="' . $messageType->id . '"]';

                $b->with($rowSelector, function (Browser $b) use ($messageType, $sentMessage) {
                    if ($messageType->id === $sentMessage->message_type_id) {
                        $b->assertVisible('.sent-icon');
                        $b->assertMissing('.not-sent-icon');
                    } else {
                        $b->assertMissing('.sent-icon');
                        $b->assertVisible('.not-sent-icon');
                    }
                });
            }

            // Shows warning when selecting already sent message
            $b->select('personData', $withMessages->id);
            $b->select('messageType', $sentMessage->message_type_id);
            $b->assertMissing('@sent-messages-none-selected-msg');
            $b->assertMissing('@sent-messages-loader');
            $b->assertVisible('@sent-messages-table-wrapper');
            $b->assertVisible('@sent-messages-already-sent-warning');

            // Updates on sponsor change
            $b->select('personData', $withoutMessages->id);
            $b->assertMissing('@sent-messages-none-selected-msg');
            $b->assertVisible('@sent-messages-loader');
            $this->waitForRequestsToFinish($b);
            $b->assertVisible('@sent-messages-table-wrapper');
            $b->assertMissing('@sent-messages-already-sent-warning');
            $b->assertVisible('.not-sent-icon');
            $b->assertMissing('.sent-icon');

            // Clears correctly
            $b->script("$('select[name=\"personData\"]').val('').trigger('change')");
            $b->assertVisible('@sent-messages-none-selected-msg');
            $b->assertMissing('@sent-messages-loader');
            $b->assertMissing('@sent-messages-table-wrapper');
            $b->assertMissing('@sent-messages-already-sent-warning');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_a_parsed_message_preview()
    {
        $this->browse(function (Browser $b) {
            /** @var SponsorshipMessageType $messageType */
            $messageType = SponsorshipMessageType::inRandomOrder()->first();
            /** @var PersonData $personData */
            $personData = PersonData::inRandomOrder()->first();
            /** @var Cat $cat */
            $cat = Cat::inRandomOrder()->first();
            $this->goToPage($b);

            // Initial state
            $b->assertSee('Pokaži predogled pisma');
            $this->assertNotNull($b->attribute('@msg-preview-generate-btn', 'disabled'));
            $b->assertMissing('@msg-preview-loader');
            $b->assertMissing('@msg-preview-content');
            $b->assertVisible('@msg-preview-disabled-text');

            // All required selects have a value - enable the button
            $b->select('messageType', $messageType->id);
            $b->select('personData', $personData->id);
            $b->select('cat', $cat->id);
            $this->assertNull($b->attribute('@msg-preview-generate-btn', 'disabled'));
            $b->assertMissing('@msg-preview-loader');
            $b->assertMissing('@msg-preview-content');
            $b->assertMissing('@msg-preview-disabled-text');

            // The btn is disabled if a required value is cleared
            $b->script("$('select[name=\"personData\"]').val('').trigger('change')");
            $this->assertNotNull($b->attribute('@msg-preview-generate-btn', 'disabled'));
            $b->assertMissing('@msg-preview-loader');
            $b->assertMissing('@msg-preview-content');
            $b->assertVisible('@msg-preview-disabled-text');

            // Make valid again
            $b->select('personData', $personData->id);
            $this->waitForRequestsToFinish($b);

            // Click the button
            $b->click('@msg-preview-generate-btn');
            $b->assertVisible('@msg-preview-loader');
            $b->assertMissing('@msg-preview-content');
            $b->assertMissing('@msg-preview-disabled-text');
            $this->assertNotNull($b->attribute('@msg-preview-generate-btn', 'disabled'));

            // Got a response
            $this->waitForRequestsToFinish($b);
            $b->assertMissing('@msg-preview-loader');
            $b->assertVisible('@msg-preview-content');
            $b->assertMissing('@msg-preview-disabled-text');
            $b->assertSee('Osveži predogled pisma');
            $this->assertNull($b->attribute('@msg-preview-generate-btn', 'disabled'));

            // Refetching
            $b->click('@msg-preview-generate-btn');
            $b->assertVisible('@msg-preview-loader');
            $b->assertMissing('@msg-preview-content');
            $b->assertMissing('@msg-preview-disabled-text');
            $this->waitForRequestsToFinish($b);
            $b->assertMissing('@msg-preview-loader');
            $b->assertVisible('@msg-preview-content');
            $b->assertMissing('@msg-preview-disabled-text');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_adding_works()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);

            /** @var SponsorshipMessageType $messageType */
            $messageType = SponsorshipMessageType::inRandomOrder()->first();
            /** @var PersonData $personData */
            $personData = PersonData::inRandomOrder()->first();
            /** @var Cat $cat */
            $cat = Cat::inRandomOrder()->first();

            $b->select('messageType', $messageType->id);
            $b->select('personData', $personData->id);
            $b->select('cat', $cat->id);
            $this->selectRadioOption($b, '@should_send_email-input-wrapper', 0);

            $this->clickSubmitButton($b);
            $b->on(new AdminSponsorshipMessageListPage);
            $b->assertSee('Vnos uspešen.');

            $this->openFirstRowDetails($b);

            $b->whenAvailable(
                '@data-table-row-details-modal',
                function (Browser $b) use ($messageType, $cat, $personData) {
                    $this->assertDetailsModalShowsValuesInOrder($b, [
                        1 => $messageType->name,
                        2 => $personData->email_and_id,
                        3 => $cat->name_and_id,
                    ]);
                }
            );
        });
    }

    /**
     * @param Browser $b
     * @throws TimeoutException
     */
    protected function goToPage(Browser $b)
    {
        $b->loginAs(static::$defaultAdmin);
        $b->visit(new AdminSponsorshipMessageListPage);
        $b->click('@crud-create-button');
        $b->on(new AdminSponsorshipMessageAddPage);

        $this->waitForRequestsToFinish($b);
    }
}
