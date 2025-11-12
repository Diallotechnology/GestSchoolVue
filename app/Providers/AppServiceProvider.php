<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

            if ($requestOrStart instanceof Request) {
                $start = $requestOrStart->input('start');
                $end = $requestOrStart->input('end');
            } else {
                $start = $requestOrStart;
            }

            // ✅ Si les deux dates sont définies
            if ($start && $end) {
                $startDate = Carbon::parse($start)->startOfDay();
                $endDate = Carbon::parse($end)->endOfDay();
                return $this->whereBetween($column, [$startDate, $endDate]);
            }

            // ✅ Si une seule date de début
            if ($start) {
                $startDate = Carbon::parse($start)->startOfDay();
                return $this->where($column, '>=', $startDate);
            }

            // ✅ Si une seule date de fin
            if ($end) {
                $endDate = Carbon::parse($end)->endOfDay();
                return $this->where($column, '<=', $endDate);
            }

            return $this;
        });
    }
}
