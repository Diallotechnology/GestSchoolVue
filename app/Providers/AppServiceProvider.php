<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

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
        Model::automaticallyEagerLoadRelationships();
        Model::shouldBeStrict(! app()->isProduction());
        URL::forceHttps(app()->isProduction());

        // Toutes les dates Eloquent seront des CarbonImmutable
        Date::use(CarbonImmutable::class);

        /**
         * Applique un filtre de plage de dates
         *
         * @param  Request|string|null  $requestOrStart
         * @param  string|null  $end
         * @param  string  $column
         */
        Builder::macro('dateRange', function ($requestOrStart, ?string $end = null, string $column = 'created_at') {
            /** @var Builder $this */

            // Cas 1 : on reçoit un Request
            if ($requestOrStart instanceof Request) {
                $start = $requestOrStart->input('start');
                $end = $requestOrStart->input('end');
            } else {
                // Cas 2 : on reçoit directement start/end
                $start = $requestOrStart;
            }

            if ($start && $end) {
                return $this->whereBetween($column, [$start, $end]);
            }

            if ($start) {
                return $this->where($column, '>=', $start);
            }

            if ($end) {
                return $this->where($column, '<=', $end);
            }

            return $this;
        });
    }
}
