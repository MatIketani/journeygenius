@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <i class="bi bi-person-fill"></i>
                        {{ trans('main.users') }}
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <table class="table table-bordered table-condensed table-vcenter">
                                    <thead>
                                    <tr class="text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">{{ trans('main.name') }}</th>
                                        <th scope="col">{{ trans('main.email') }}</th>
                                        <th scope="col">{{ trans('main.locale') }}</th>
                                        <th scope="col">{{ trans('main.last_login_at') }}</th>
                                        <th scope="col">{{ trans('main.created_at') }}</th>
                                        <th scope="col">{{ trans('main.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ strtoupper($user->locale->code) }}</td>
                                                <td>{{ $user->last_login_at?->toDateTimeString() ?: trans('main.na') }}</td>
                                                <td>{{ $user->created_at->toDateTimeString() }}</td>
                                                @canany(['delete-users'])
                                                    <td class="text-center">
                                                        @can('delete-users')
                                                            <a class="btn btn-sm btn-danger"
                                                                @if(\App\Models\Auth\User::getInstance()->id === $user->id) disabled @else href="{{ route('users_management.delete', encrypt($user->id)) }}" @endif>
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        @endcanany
                                                    </td>
                                                @endcanany
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
