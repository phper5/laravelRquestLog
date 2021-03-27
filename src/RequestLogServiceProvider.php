<?php


namespace SoftDD\RequestLog;


use Illuminate\Support\ServiceProvider;

class RequestLogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $source = realpath($raw = __DIR__.'/../config/softDDRequestLog.php') ?: $raw;
        $this->publishes([$source => config_path('softDDRequestLog.php')]);
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
