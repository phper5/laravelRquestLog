<?php


namespace SoftDD\RequestLog;


use Illuminate\Support\ServiceProvider;

class RequestLogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $source = realpath($raw = __DIR__.'/../config/ddRequestLog.php') ?: $raw;
        $this->publishes([$source => config_path('ddRequestLog.php')]);
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
