<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;

/**
 * Class DuskServiceProvider
 * @package App\Providers
 */
class DuskServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Browser::macro('disableClientSideValidation', function () {
            /** @var Browser $this */
            $this->script('for(var f=document.forms,i=f.length;i--;)f[i].setAttribute("novalidate",i)');

            return $this;
        });

        Browser::macro('enableClientSideValidation', function () {
            /** @var Browser $this */
            $this->script('for(var f=document.forms,i=f.length;i--;)f[i].removeAttribute("novalidate")');

            return $this;
        });
    }
}
