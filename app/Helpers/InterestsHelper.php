<?php

namespace App\Helpers;

class InterestsHelper
{
    /**
     * Return the current interests list.
     *
     * @return array
     */
    public static function interestsList(): array
    {
        return [
            'night_club' => __('Nightlife Experiences'),
            'restaurant' => __('Local Restaurants'),
            'tourist_attraction' => __('Tourist Attractions'),
            'event' => __('Cultural Events'),
            'shopping_mall' => __('Shopping Areas'),
            'park' => __('Outdoor Activities'),
            'museum' => __('Museums and Galleries'),
            'natural_feature' => __('Nature'),
            'movie_theater' => __('Entertainment Options'),
        ];
    }
}
