<?php

namespace congnguyentan\NotifyPackage;

use Illuminate\Support\ServiceProvider;

class NotifyPackageServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->_isLumen()) {
            $this->loadTranslationsFrom(__DIR__ . '/../translates', 'notify');

            $this->publishes(array(
                __DIR__ . '/../config/notify.php' => config_path('notify.php')
            ), "config");

            $this->publishes(array(
                __DIR__ . '/../translates/en/email.php' => resource_path('lang/en/email.php'),
                __DIR__ . '/../translates/en/sms.php' => resource_path('lang/en/sms.php')
            ), "localize");

            $this->registerHelpers();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register helpers file
     */
    public function registerHelpers()
    {
        // Load the helpers
        if (file_exists($file = __DIR__ . "/helpers.php"))
        {
            require $file;
        }
    }

    /**
     * Check is Lumen framework
     *
     * @return boolean
     */
    private function _isLumen()
    {
        return preg_match('/lumen/i', app()->version());
    }
}