<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Balancer'        => 'App\Policies\BalancerPolicy',
        'App\Models\Database'        => 'App\Policies\DatabasePolicy',
        'App\Models\DatabaseBackup'  => 'App\Policies\DatabaseBackupPolicy',
        'App\Models\DatabaseRestore' => 'App\Policies\DatabaseRestorePolicy',
        'App\Models\Project'         => 'App\Policies\ProjectPolicy',
        'App\Models\Environment'     => 'App\Policies\EnvironmentPolicy',
        'App\Models\Stack'           => 'App\Policies\StackPolicy',
        'App\Services\AppServer'     => 'App\Policies\AppServerPolicy',
        'App\Models\WebServer'       => 'App\Policies\WebServerPolicy',
        'App\Models\WorkerServer'    => 'App\Policies\WorkerServerPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
