<?php


namespace SoftDD\RequestLog;


use Illuminate\Support\ServiceProvider;

class RequestLogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $source = realpath($raw = __DIR__.'/../config/dd-requestLog.php') ?: $raw;
        $this->publishes([$source => config_path('dd-requestLog.php')]);
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
