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
            'nightlife_experiences' => __('Nightlife Experiences'),
            'local_restaurants' => __('Local Restaurants'),
            'tourist_attractions' => __('Tourist Attractions'),
            'cultural_events' => __('Cultural Events'),
            'shopping_areas' => __('Shopping Areas'),
            'historical_sites' => __('Historical Sites'),
            'outdoor_activities' => __('Outdoor Activities'),
            'museums_and_galleries' => __('Museums and Galleries'),
            'beaches_and_nature' => __('Beaches and Nature'),
            'entertainment_options' => __('Entertainment Options'),
        ];
    }
}
