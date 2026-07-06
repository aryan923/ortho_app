<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        try {
            if (Schema::hasTable('settings')) {
                $settings = Setting::pluck('value', 'key')->all();

                foreach ($settings as $key => $value) {
                    if (str_starts_with($key, 'site_')) {
                        $configKey = 'site.' . str_replace('site_', '', $key);
                        config([$configKey => $value]);
                    }

                    if ($key === 'pagination_default') {
                        config(['site.pagination.default' => $value]);
                    }

                    if ($key === 'pagination_search') {
                        config(['site.pagination.search' => $value]);
                    }
                }

                if (empty(config('site.phone_link')) && config('site.phone')) {
                    $phoneLink = 'tel:' . preg_replace('/[^\d+]/', '', config('site.phone'));
                    config(['site.phone_link' => $phoneLink]);
                }
            }
        } catch (\Exception $e) {
            // Ignore if the settings table is not yet available.
        }
    }
}
