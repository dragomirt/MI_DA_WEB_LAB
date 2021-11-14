<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        tap($app->make('config'), function ($config) {
            $config->set('app.url', 'http://laravel.test');
            $config->set('database.default', 'dusk_testing');
            $config->set('mail.driver', 'log');
            $config->set('laravel2step.laravel2stepDatabaseConnection', 'dusk_testing');
        });

        return $app;
    }
}
