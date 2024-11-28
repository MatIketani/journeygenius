<?php

namespace App\Jobs\TravelPlans;

use App\Helpers\InterestsHelper;
use App\Http\Clients\GoogleMapsClient;
use App\Http\Clients\LLM\CohereTravelPlanClient;
use App\Models\TravelPlans\TravelPlan;
use App\Notifications\TravelPlans\TravelPlanProcessed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JetBrains\PhpStorm\NoReturn;

class ProcessTravelPlan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private TravelPlan $travelPlan;

    /**
     * Create a new job instance.
     */
    public function __construct(TravelPlan $travelPlan)
    {
        $this->travelPlan = $travelPlan;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $consolidatedResults = $this->getConsolidatedResults();

        $cohereTravelPlanClient = new CohereTravelPlanClient();

        $cohereTravelPlanClient->setChatHistory([
            [
                'role' => 'user',
                'message' => 'Here is the list of valid establishments: ' . json_encode($consolidatedResults)
            ]
        ]);

        $prompt = '
            Generate an travel plan with the provided data following the defined structure.
            Storytelling should vary based on the type of establishment.
            For example, describe the vibrant atmosphere for nightclubs, local flavors for restaurants,
            or the cultural significance for museums.
            You should return the content using the following locale: ' . $this->travelPlan->user->locale->code . '
        ';

        $cohereTravelPlanClient->setPrompt($prompt);

        $result = $cohereTravelPlanClient->generateTravelPlanHtml();

        if (!$result) {

            $this->handleFailure();

            return;
        }

        $this->handleSuccess($result);
    }

    /**
     * Return the consolidated results from Google Maps nearby endpoint.
     *
     * @return array
     */
    private function getConsolidatedResults(): array
    {
        $consolidatedResults = [];

        $interestsList = InterestsHelper::interestsList();

        $accommodationCoordinates = $this->travelPlan->accommodation_coordinates;

        foreach ($this->travelPlan->interests as $interestKey) {

            $responseData = GoogleMapsClient::getNearby(
                $accommodationCoordinates['lat'] . ' ' . $accommodationCoordinates['lng'],
                $this->travelPlan->max_distance,
                [
                    'keyword' => $interestKey,
                    'language' => $this->travelPlan->user->locale->code,
                    'rankby' => 'prominence',
                ]
            );

            $responseCollection = collect($responseData)->map(function ($establishment) use ($interestsList, $interestKey) {

                return [
                    'establishment_name' => $establishment['name'],
                    'establishment_type' => $interestsList[$interestKey],
                    'address' => $establishment['vicinity'],
                    'rating' => $establishment['rating'] ?? 'N/A',
                    'user_ratings_total' => $establishment['user_ratings_total'] ?? 'N/A',
                ];
            })
                ->take(1)
                ->toArray();

            $consolidatedResults[$interestKey] = $responseCollection;
        }

        return $consolidatedResults;
    }

    /**
     * Handle the failure of the Travel Plan processing.
     *
     * @return void
     */
    private function handleFailure(): void
    {
        $this->travelPlan->status = 3;

        $this->travelPlan->save();
    }

    /**
     * Handle the success of the Travel Plan processing.
     *
     * Sends an notification to the user.
     *
     * @param string $result
     * @return void
     */
    private function handleSuccess(string $result): void
    {
        $this->travelPlan->status = 2;

        $this->travelPlan->result = $result;

        $this->travelPlan->save();

        $this->travelPlan->user->notify(new TravelPlanProcessed($this->travelPlan));

        $this->travelPlan->user->wallet->decreaseCredits(5);
    }
}
