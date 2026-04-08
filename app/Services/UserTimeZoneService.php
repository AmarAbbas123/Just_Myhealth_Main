<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserTimeZoneService
{
    public function getCountryOptions(): array
    {
        return DB::table('sys_timezone_lookup')
            ->select('CountryName')
            ->whereNotNull('CountryName')
            ->where('CountryName', '!=', '')
            ->distinct()
            ->orderBy('CountryName')
            ->pluck('CountryName')
            ->values()
            ->all();
    }

    public function resolveTimezoneNameByCountry(?string $countryName): string
    {
        if (!is_string($countryName) || trim($countryName) === '') {
            return 'UTC';
        }

        $countryName = trim($countryName);

        $row = DB::table('sys_timezone_lookup as l')
            ->leftJoin('sys_timezones_country as c', function ($join) {
                $join->on('c.timezone_id', '=', 'l.ID')
                    ->on('c.CountryCode', '=', 'l.CountryCode');
            })
            ->where('l.CountryName', $countryName)
            ->select([
                'l.IdentifierFull',
                DB::raw('COALESCE(c.is_primary, 0) as is_primary'),
                DB::raw('COALESCE(l.Population, 0) as population'),
            ])
            ->orderByDesc('is_primary')
            ->orderByDesc('population')
            ->orderBy('l.ID')
            ->first();

        $timezoneName = $row?->IdentifierFull;

        return $this->isValidTimezoneName($timezoneName) ? $timezoneName : 'UTC';
    }

    public function getUserHomeTimezoneName(?User $user): string
    {
        $timezoneName = $user?->userAttributes?->UserHomeTimeZoneName;

        return $this->isValidTimezoneName($timezoneName) ? $timezoneName : 'UTC';
    }

    public function getUtcOffsetForTimezone(string $timezoneName, ?Carbon $at = null): string
    {
        $timezoneName = $this->isValidTimezoneName($timezoneName) ? $timezoneName : 'UTC';
        $at = $at ? $at->copy() : now('UTC');

        try {
            return $at->copy()->setTimezone($timezoneName)->format('P');
        } catch (Throwable) {
            return '+00:00';
        }
    }

    private function isValidTimezoneName(?string $timezoneName): bool
    {
        if (!is_string($timezoneName) || $timezoneName === '') {
            return false;
        }

        return in_array($timezoneName, timezone_identifiers_list(), true);
    }
}

