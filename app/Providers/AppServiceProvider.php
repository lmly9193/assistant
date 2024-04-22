<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Casts\Json as EloquentJsonCast;

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
        EloquentJsonCast::encodeUsing(fn ($value) => json_encode($value, JSON_UNESCAPED_UNICODE));
    }
}
