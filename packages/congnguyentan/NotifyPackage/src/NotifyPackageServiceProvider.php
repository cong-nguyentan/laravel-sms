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
            $this->publishes(array(
                __DIR__ . '/../config/notify.php' => config_path('notify.php')
            ), "config");
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
     * Check is Lumen framework
     * 
     * @return boolean
     */
    private function _isLumen()
    {
        return preg_match('/lumen/i', app()->version());
    }
}