<?php

namespace App\Providers;

use Prettus\Repository\Providers\RepositoryServiceProvider as RepositoryServiceProviderAlias;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends RepositoryServiceProviderAlias {

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        $this->bindProviders();
    }

    /**
     * @return void
     */
    public function bindProviders(): void {
        foreach (config('repository.repositories') as $repositoryContract => $repositoryClass) {
            $this->app->bind($repositoryContract, $repositoryClass);
        }
    }
}
