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
        return trans('main.interests_list');
    }
}
