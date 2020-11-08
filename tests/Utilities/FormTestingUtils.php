<?php

namespace Tests\Utilities;

use Laravel\Dusk\Browser;

class FormTestingUtils
{
    /**
     * @param Browser $browser
     * @param array $requiredInputWrapperSelectors
     */
    public static function assertAllRequiredErrorsAreShown(Browser $browser, array $requiredInputWrapperSelectors)
    {
        foreach ($requiredInputWrapperSelectors as $selector) {
            $browser->with($selector, function (Browser $wrapper) {
                $wrapper->assertSee(trans('validation.required'));
            });
        }
    }
}
