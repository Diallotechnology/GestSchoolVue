<?php

declare(strict_types=1);

namespace App\Helper;

use Closure;
use DateInterval;
use DateTimeInterface;
use App\Helper\CacheHelper;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

trait DateFormat
{
    use HasFactory, CacheHelper, HasSearch;

    public function getDelaiFormatAttribute(): string
    {
        return Carbon::parse($this->delai)->format('d/m/Y');
    }

    public function getMontantFormatAttribute(): string
    {
        return number_format($this->montant, 0, ',', ' ') . ' CFA';
    }




    public function forDateRaw(string $field)
    {
        $this->{$field . '_raw'} = optional($this->{$field})->toDateString();
        return $this;
    }

    public function forDateFormat(?string $field = '')
    {
        if ($field) {
            return $this->{$field}->format('d/m/Y');
        }
        return $this->created_at->format('d/m/Y');
    }
}
