<?php

namespace App\Providers;

use App\Models\Doctor;
use App\Models\Nurse;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        }

        Relation::morphMap([
            'doctor' => Doctor::class,
            'nurse'  => Nurse::class,
        ]);
    }
}
