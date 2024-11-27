@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ trans('main.create_travel_plan') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('travel-plans.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="accommodation"
                                       class="col-md-4 col-form-label text-md-end">{{ trans('main.accommodation') }} <span
                                        class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="accommodation" type="text"
                                           class="form-control @error('accommodation') is-invalid @enderror" autofocus>

                                    @error('accommodation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    <input type="hidden" id="accommodation-lat-lng" name="accommodation">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <span class="col-md-7 col-form-label text-md-end" id="max-distance-display">
                                    <strong>10 Km</strong>
                                </span>
                            </div>

                            <div class="row mb-3">
                                <label for="max-distance"
                                       class="col-md-4 col-form-label text-md-end">{{ trans('main.maximum_distance') }}
                                    <span class="text-danger"></span></label>

                                <div class="col-md-6">
                                    <input type="range" class="form-range" id="max-distance" name="max_distance" min="1"
                                           max="50" value="10" onchange="updateMaxDistanceDisplay()">

                                    @error('max_distance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="interests" class="col-md-4 col-form-label text-md-end">{{ trans('main.interests') }}
                                    <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    @foreach ($interests as $interestId => $interest)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="interests[]"
                                                   id="{{ $interestId }}" value="{{ $interestId }}">
                                            <label class="form-check-label" for="{{ $interestId }}">
                                                {{ $interest }}
                                            </label>
                                        </div>
                                    @endforeach

                                    @error('interests')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="spending"
                                       class="col-md-4 col-form-label text-md-end">{{ trans('main.spending') }}</label>

                                <div class="col-md-6">
                                        <input type="range" class="form-range" id="spending" name="spending" min="1"
                                               max="4" value="1" onchange="updateSpendingDisplay()">

                                        @error('spending')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>

                                <span class="col-md-2">
                                    <strong id="spending-display">$</strong>
                                </span>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('main.process_travel_plan') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initAutocomplete"
        defer></script>
    <script>
        /**
         * Callback function for the Google Maps API place input.
         *
         * It its triggered on place_changed event.
         */
        function onPlaceChanged() {

            const place = autoComplete.getPlace();

            if (!place.geometry) {

                return;
            }

            const location = place.geometry.location;

            const latitudeLongitude = {
                "lat": location.lat(),
                'lng': location.lng(),
            };

            document.getElementById('accommodation-lat-lng').value = JSON.stringify(latitudeLongitude);
        }

        let autoComplete;

        /**
         * Google Maps API Callback function.
         */
        function initAutocomplete() {

            autoComplete = new google.maps.places.Autocomplete(
                document.getElementById('accommodation'),
                {
                    types: ['lodging'],
                    fields: ['geometry']
                },
            );

            autoComplete.addListener('place_changed', onPlaceChanged);
        }

        /**
         * Updates the Max Distance display.
         *
         * Called by the onchange event on max distance input.
         */
        function updateMaxDistanceDisplay () {

            const maxDistance = document.querySelector('#max-distance').value;

            const maxDistanceDisplay = document.querySelector('#max-distance-display');

            maxDistanceDisplay.innerHTML = `<strong>${maxDistance} Km</strong>`
        }

        /**
         * Updates the Spending display.
         */
        function updateSpendingDisplay() {

            const spending = document.querySelector('#spending').value;

            const spendingDisplay = document.querySelector('#spending-display');

            spendingDisplay.innerHTML = `$`.repeat(spending);
        }
    </script>
@endsection
