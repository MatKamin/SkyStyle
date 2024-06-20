<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Session\CustomDatabaseSessionHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Session::extend('custom_database', function ($app) {
            $connection = $app['db']->connection(config('session.connection'));
            $table = config('session.table');
            $lifetime = config('session.lifetime');

            return new CustomDatabaseSessionHandler($connection, $table, $lifetime, $app);
        });

        config(['session.driver' => 'custom_database']);
    }
}
