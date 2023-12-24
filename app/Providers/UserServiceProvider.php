<?php

namespace App\Providers;

use App\Services\UserService;
use App\Services\Impl\UserServiceImpl;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class UserServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        UserService::class => UserServiceImpl::class
    ];

    public function provides(): array
    {
        return [UserService::class];
    }
    
    public function register()
    {
        //
    }

   
    public function boot()
    {
        //
    }
}
