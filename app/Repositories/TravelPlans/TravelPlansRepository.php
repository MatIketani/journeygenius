<?php

namespace App\Repositories\TravelPlans;

use App\Models\TravelPlans\TravelPlan;

class TravelPlansRepository
{
    /**
     * Create a new Travel Plan instance.
     *
     * @param int $userId
     * @param array $accommodationCoordinates
     * @param int $maxDistance
     * @param array $interests
     * @param int $spending
     * @return TravelPlan
     */
    public function create(
        int $userId,
        array $accommodationCoordinates,
        int $maxDistance,
        array $interests,
        int $spending,
    ): TravelPlan
    {
        /**
         * @var TravelPlan $travelPlan
         */
        $travelPlan = TravelPlan::query()->create([
            'user_id' => $userId,
            'accommodation_coordinates' => $accommodationCoordinates,
            'max_distance' => $maxDistance,
            'interests' => $interests,
            'spending' => $spending,
        ]);

        return $travelPlan;
    }

    /**
     * Get Travel Plan by ID.
     *
     * @param int $id
     * @return ?TravelPlan
     */
    public function getById(int $id): ?TravelPlan
    {
        /**
         * @var TravelPlan $travelPlan
         */
        $travelPlan = TravelPlan::query()->find($id);

        return $travelPlan;
    }
}
