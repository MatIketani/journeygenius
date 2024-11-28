<?php

namespace App\Http\Controllers\TravelPlans;

use App\Helpers\InterestsHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TravelPlanValidator;
use App\Jobs\TravelPlans\ProcessTravelPlan;
use App\Models\Auth\User;
use App\Models\TravelPlans\TravelPlan;
use App\Repositories\TravelPlans\TravelPlansRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TravelPlansController extends Controller
{
    private TravelPlansRepository $travelPlansRepository;

    /**
     * Travel Plans Controller constructor.
     */
    public function __construct(TravelPlansRepository $travelPlansRepository)
    {
        $this->travelPlansRepository = $travelPlansRepository;
    }

    /**
     * GET /travel-plans/create
     *
     * Display the form to create a new travel plan.
     *
     * @return View
     */
    public function create(): View
    {
        return view('travel-plans.create', [
            'interests' => InterestsHelper::interestsList()
        ]);
    }

    /**
     * POST /travel-plans/store
     *
     * Process the Travel Plan
     *
     * @param TravelPlanValidator $request
     * @return RedirectResponse
     */
    public function store(TravelPlanValidator $request): RedirectResponse
    {
        $currentUser = User::getInstance();

        if ($currentUser->wallet->credits < TravelPlan::TRAVEL_PLAN_CREDITS_COST) {

            return redirect()->back()->with('error', trans('messages.not_enough_credits'));
        }

        $requestData = $request->validated();

        $travelPlan = $this->travelPlansRepository->create(
            User::getInstance()->id,
            $requestData['accommodation'],
            $requestData['max_distance'],
            $requestData['interests'],
            $requestData['spending']
        );

        $job = new ProcessTravelPlan($travelPlan);

        dispatch($job);

        return redirect()->back()->with(
            'success', trans('messages.processing_travel_plan')
        );
    }

    /**
     * GET /travel-plans
     *
     * @return Application|Factory|\Illuminate\Foundation\Application|View
     */
    public function viewAll(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $currentUser = User::getInstance();

        $travelPlans = $this->travelPlansRepository->getAllByUser($currentUser);

        return view('travel-plans.view', ['travelPlans' => $travelPlans]);
    }

    /**
     * GET /travel-plans/{id}
     *
     * @param string $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(string $id): Factory|View|\Illuminate\Foundation\Application|Application
    {
        $travelPlanId = decrypt($id);

        $travelPlan = $this->travelPlansRepository->getById($travelPlanId);

        if (!$travelPlan) {

            abort(404);
        }

        return view('travel-plans.show', [
            'travelPlan' => $travelPlan
        ]);
    }

    /**
     * GET /travel-plans/{id}/delete
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function delete(string $id): RedirectResponse
    {
        $travelPlanId = decrypt($id);

        $travelPlan = $this->travelPlansRepository->getById($travelPlanId);

        if (!$travelPlan) {

            abort(404);
        }

        if ($travelPlan->user_id != User::getInstance()->id) {

            abort(401);
        }

        $travelPlan->delete();

        return redirect()->route('travel-plans.view-all')->with(
            'success', trans('messages.travel_plan_successfully_deleted'),
        );
    }
}
