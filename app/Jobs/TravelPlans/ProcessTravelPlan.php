<?php

namespace App\Jobs\TravelPlans;

use App\Helpers\InterestsHelper;
use App\Http\Clients\GoogleMapsClient;
use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JetBrains\PhpStorm\NoReturn;

class ProcessTravelPlan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $accommodationCoordinates;

    private int $maxDistance;

    private array $interests;

    private int $spending;

    private User $user;

    /**
     * Create a new job instance.
     */
    public function __construct(
        array $accommodationCoordinates,
        int   $maxDistance,
        array $interests,
        int   $spending,
        User  $user,
    )
    {
        $this->accommodationCoordinates = $accommodationCoordinates;

        $this->maxDistance = $maxDistance; // TODO: Validar o por que do maxDistance estar vindo 1 da requisição.

        $this->interests = $interests;

        $this->spending = $spending;

        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    #[NoReturn] public function handle(): void
    {
        $consolidatedResults = $this->getConsolidatedResults();

        /**
         * TODO: Integração com a Cohere
         */
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

        foreach ($this->interests as $interestKey) {

            $interest = $interestsList[$interestKey];

            $consolidatedResults[$interestKey] = json_encode(GoogleMapsClient::getNearby(
                $this->accommodationCoordinates['lat'] . ' ' . $this->accommodationCoordinates['lng'],
                $this->maxDistance,
                [
                    'keyword' => $interest,
                    'language' => $this->user->locale->code,
                    'rankby' => 'prominence'
                ]
            ));
        }

        return $consolidatedResults;
    }
}
