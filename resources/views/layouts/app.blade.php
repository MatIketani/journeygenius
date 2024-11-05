<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('js')

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @yield('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ trans('main.toggle_navegation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ trans('main.login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ trans('main.register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="travel-plans-dropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{trans('main.travel_plans')}}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="travel-plans-dropdown">
                                    <a class="dropdown-item" href="{{ route('travel-plans.create') }}">
                                        {{ trans('main.create') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('travel-plans.view-all') }}">
                                        {{ __('View') }}
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    <i class="bi bi-coin"></i>
                                    <b>{{ trans(main.credits) }}:</b> {{ Auth::user()->wallet->credits }}
                                </a>
                            </li>
                            @canany(['see-users-management'])
                                <li class="nav-item dropdown">
                                    <a id="users-management-dropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="bi bi-person-fill"></i>
                                        {{ trans('main.users') }}
                                    </a>

                                    @can('see-users-management')
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="users-management-dropdown">
                                            <a class="dropdown-item" href="{{ route('users_management.index') }}">
                                                {{ trans('main.show') }}
                                            </a>
                                        </div>
                                    @endcan
                                </li>
                            @endcanany
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('settings.index') }}">
                                        {{ trans('main.settings') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ trans('main.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if(session('success'))
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="alert alert-success text-center" role="alert" style="width: 65%;">
                            {!! session('success') !!}
                        </div>
                    </div>
                </div>
            @elseif(session('error'))
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="alert alert-danger text-center" role="alert" style="width: 65%;">
                            {!! session('error') !!}
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
