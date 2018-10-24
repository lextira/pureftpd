<?php

namespace App\Providers;

use App\Data\Repositories\Interfaces\AccountRepository;
use App\Data\Repositories\AccountRepositoryEloquent;
use App\Data\Repositories\Interfaces\DomainRepository;
use App\Data\Repositories\DomainRepositoryEloquent;
use App\Data\Repositories\Interfaces\KeyRepository;
use App\Data\Repositories\KeyRepositoryEloquent;
use App\Data\Repositories\Interfaces\UserRepository;
use App\Data\Repositories\UserRepositoryEloquent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(AccountRepository::class, AccountRepositoryEloquent::class);
        App::bind(DomainRepository::class, DomainRepositoryEloquent::class);
        App::bind(KeyRepository::class, KeyRepositoryEloquent::class);
        App::bind(UserRepository::class, UserRepositoryEloquent::class);
    }
}
