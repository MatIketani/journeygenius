<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;

class GoogleMapsClient
{
    const BASE_URL = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json';

    /**
     * Make a GET request to the Google Maps API to get nearby places.
     *
     * @param string $location Base location, latitude,longitude format.
     * @param int $radius Radius in meters.
     * @param array $optionalParameters Other possible parameters, such as keyword, language, max price, min price, etc
     *
     * @return array|null
     */
    public static function getNearby(string $location, int $radius, array $optionalParameters = []): ?array
    {
        return Http::get(self::BASE_URL, [
            'location' => $location,
            'radius' => $radius * 1000,
            ...$optionalParameters,
            'key' => config('services.maps.key')
        ])
            ->json()['results'] ?? null;
    }
}
