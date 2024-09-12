<?php

namespace App\Providers;

use App\Interfaces\AddressesRepositoryInterface;
use App\Interfaces\AuthenticationRepositoryInterface;
use App\Interfaces\ContactsRepositoryInterface;
use App\Repositories\AddressesRepository;
use App\Repositories\AuthenticationRepository;
use App\Repositories\ContactsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthenticationRepositoryInterface::class, AuthenticationRepository::class);
        $this->app->bind(ContactsRepositoryInterface::class, ContactsRepository::class);
        $this->app->bind(AddressesRepositoryInterface::class, AddressesRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
