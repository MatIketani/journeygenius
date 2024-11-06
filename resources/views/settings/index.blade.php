@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ trans('main.settings') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('settings.confirm-changes') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ trans('main.name') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ trans('main.email_address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" disabled type="email" class="form-control" value="{{ $user->email }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ trans('main.current_password') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="new-password" class="col-md-4 col-form-label text-md-end">{{ trans('main.new_password') }}</label>

                                <div class="col-md-6">
                                    <input id="new-password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" autocomplete="new-password">

                                    @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="new-password-confirmation" class="col-md-4 col-form-label text-md-end">{{ trans('main.confirm_new_password') }}</label>

                                <div class="col-md-6">
                                    <input id="new-password-confirmation" type="password" class="form-control"  @error('new_password_confirmation') @enderror name="new_password_confirmation" autocomplete="new-password-confirmation">

                                    @error('new_password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="locale" class="col-md-4 col-form-label text-md-end">{{ trans('main.locale') }}</label>

                                <div class="col-md-6">

                                    <select id="locale" class="form-select" aria-label="{{ trans('main.locale') }}" name="locale">
                                        @foreach ($localeList as $localeId => $localeCode)
                                            <option value="{{ $localeId }}" @if ($user->locale_id === $localeId) selected @endif>
                                                {{ trans("locales.$localeCode") }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('locale')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="my-invite-code" class="col-md-4 col-form-label text-md-end">{{trans('main.my_invite_code') }}</label>

                                <div class="col-md-2">
                                    <input id="my-invite-code" type="text" class="form-control" disabled value="{{ $user->invite_code->code }}">
                                </div>

                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary" onclick="copyInviteLink()">
                                        {{trans('main.copy_invite_link') }}
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('main.confirm_changes') }}
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
    <script>
        const inviteLink = '{{ route('invitation.register', ['inviteCode' => encrypt($user->invite_code->code)]) }}';

        /**
         * Add the invite link to clipboard.
         */
        function copyInviteLink()
        {
            navigator.clipboard.writeText(inviteLink);
        }
    </script>
@endsection
