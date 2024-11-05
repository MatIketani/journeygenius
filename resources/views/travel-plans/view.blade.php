@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">{{ trans('main.travel_plans') }}</div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <table class="table table-bordered table-condensed table-vcenter">
                                    <thead>
                                    <tr class="text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">{{ trans('main.status') }}</th>
                                        <th scope="col">{{ trans('main.created_at') }}</th>
                                        <th scope="col">{{ trans('main.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($travelPlans as $travelPlan)
                                        <tr>
                                            <td>{{ $travelPlan->id }}</td>
                                            <td>{{ $travelPlan->status_for_humans }}</td>
                                            <td>{{ $travelPlan->created_at->toDateTimeString() }}</td>
                                            <td class="text-center">
                                                <a @if ($travelPlan->status === 2) href="{{ route('travel-plans.show', encrypt($travelPlan->id)) }}" @else disabled @endif class="btn btn-sm btn-primary">
                                                    <i class="bi bi-airplane"></i>
                                                </a>
                                                <a @if ($travelPlan->status === 2) href="{{ route('travel-plans.delete', encrypt($travelPlan->id)) }}" @else disabled @endif class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
