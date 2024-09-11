@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Travel Plan') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('travel-plans.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="accommodation"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Accommodation') }} <span
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
                                <label for="max-distance"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Maximum Distance (1-50 Km)') }}
                                    <span class="text-danger"></span></label>

                                <div class="col-md-6">
                                    <input type="range" class="form-range" id="max-distance" name="max_distance" min="1"
                                           max="50" value="10">

                                    @error('max_distance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="interests" class="col-md-4 col-form-label text-md-end">{{ __('Interests') }}
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
                                       class="col-md-4 col-form-label text-md-end">{{ __('Spending ($-$$$$$)') }}</label>

                                <div class="col-md-6">
                                    <div class="col-md-6">
                                        <input type="range" class="form-range" id="spending" name="spending" min="1"
                                               max="5" value="1">

                                        @error('spending')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Process Travel Plan') }}
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
        async defer></script>
    <script>
        function onPlaceChanged() {

            const place = autoComplete.getPlace();

            if (!place.geometry) {

                return;
            }

            const location = place.geometry.location;

            const latLng = location.lat() + ' ' + location.lng();

            document.getElementById('accommodation-lat-lng').value = latLng;
        }

        let autoComplete;

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
    </script>
@endsection
