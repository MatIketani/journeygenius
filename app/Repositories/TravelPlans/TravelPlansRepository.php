<?php

namespace App\Repositories\TravelPlans;

use App\Models\Auth\User;
use App\Models\TravelPlans\TravelPlan;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * Return all the travel plans for the specified user.
     *
     * @param User $user
     * @return Collection
     */
    public function getAllByUser(User $user): Collection
    {
        return TravelPlan::query()->where('user_id', $user->id)->get();
    }
}
