<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\Ssh;

/**
 * Class SshServiceProvider
 */
class SshServiceProvider extends ServiceProvider
{
    /** @var bool $defer Only load this service provider when needed */
    protected $defer = true;

    /**
     * Register the application services
     * @return void
     */
    public function register()
    {
        $this->app->bind(Ssh::class, function () {
            return new Ssh(
                \Auth::getUser()
            );
        });
    }

    /** @noinspection PhpMissingParentCallCommonInspection */
    /**
     * Get the services provided by the provider
     * @return array
     */
    public function provides() : array
    {
        return [
            Ssh::class
        ];
    }
}
