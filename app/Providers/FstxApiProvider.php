<?php

namespace App\Providers;

use App\FstxApi;
use Illuminate\Support\ServiceProvider;

class FstxApiProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('FstxApi', function ($app) {
            $FstxApi = new FstxApi(\Config::get('fapi.server').'/api/v1/', OPENSSL_ALGO_SHA512);
            $FstxApi->set_privkey(\Config::get('fapi.my_private_key'));
            $FstxApi->set_uid(\Config::get('fapi.my_unique_id'));
            $FstxApi->set_serverpubkey(\Config::get('fapi.server_public_key'));
            return $FstxApi;
        });
    }
}
