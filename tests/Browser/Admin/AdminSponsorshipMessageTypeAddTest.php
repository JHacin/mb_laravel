<?php

namespace Tests\Browser\Admin;

use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorshipMessageTypeAddPage;
use Tests\Browser\Pages\Admin\AdminSponsorshipMessageTypeListPage;
use Throwable;

class AdminSponsorshipMessageTypeAddTest extends AdminTestCase
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
            $this->assertAllRequiredErrorsAreShown($b, ['@name-wrapper', '@template_id-wrapper']);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_name()
    {
        $this->browse(function (Browser $b) {
            // Unique
            $name = 'test';
            $this->createSponsorshipMessageType(['name' => $name]);
            $this->goToPage($b);
            $this->disableHtmlFormValidation($b);
            $b->type('name', $name);
            $this->clickSubmitButton($b);
            $b->assertSeeIn('@name-wrapper', 'Izbrano ime je že v uporabi.');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_template_id()
    {
        $this->browse(function (Browser $b) {
            // Unique
            $templateId = 'template_id_test';
            $this->createSponsorshipMessageType(['template_id' => $templateId]);
            $this->goToPage($b);
            $this->disableHtmlFormValidation($b);
            $b->type('template_id', $templateId);
            $this->clickSubmitButton($b);
            $b->assertSeeIn('@template_id-wrapper', 'Izbrana šifra predloge je že v uporabi.');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_handles_successful_submission()
    {
        $this->browse(function (Browser $b) {
            $name = 'name-' . time();
            $templateId = 'template-id-' . time();

            $this->goToPage($b);
            $b->type('name', $name);
            $b->type('template_id', $templateId);
            $this->clickCheckbox($b, '@is_active-wrapper');
            $this->clickSubmitButton($b);

            $b->assertSee('Vnos uspešen.');
            $this->assertDatabaseHas('sponsorship_message_types', [
               'name' => $name,
               'template_id' => $templateId,
            ]);
        });
    }

    /**
     * @param Browser $browser
     * @throws TimeoutException
     */
    protected function goToPage(Browser $browser)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminSponsorshipMessageTypeListPage)
            ->click('@crud-create-button')
            ->on(new AdminSponsorshipMessageTypeAddPage);

        $this->waitForRequestsToFinish($browser);
    }
}
