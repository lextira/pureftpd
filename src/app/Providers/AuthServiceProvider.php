<?php

namespace App\Providers;

use App\Key;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('bearer-token', function($request){
            // remove "Bearer " from start
            $token = substr($request->header('Authorization'), 7);
            // get the key
            return Key::where('token', $token)->first();
        });

        //
    }
}
