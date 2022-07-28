<?php

namespace App\Providers;
use Spatie\Health\Facades\Health;
use Illuminate\Support\ServiceProvider;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;

use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;

class HealthProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Health::checks([
            CpuLoadCheck::new()
                ->failWhenLoadIsHigherInTheLast5Minutes(2.0)
                ->failWhenLoadIsHigherInTheLast15Minutes(1.5),
            OptimizedAppCheck::new(),
            DatabaseCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            ScheduleCheck::new(),
            UsedDiskSpaceCheck::new()
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
