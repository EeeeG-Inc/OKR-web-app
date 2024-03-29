<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" rel="stylesheet">

    @stack('scripts-head')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @if(Auth::check())
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    {{ link_to_route('dashboard.index', __('common/nav.dashboard.index'), null, ['class' => 'nav-link']) }}
                                </li>
                                @can('member-higher')
                                    <li class="nav-item">
                                        {{ link_to_route('objective.index', __('common/nav.objective.index'), null, ['class' => 'nav-link']) }}
                                    </li>
                                    <li class="nav-item">
                                        {{ link_to_route('quarter.index', __('common/nav.quarter.index'), null, ['class' => 'nav-link']) }}
                                    </li>
                                @endcan
                            @endif
                        </ul>
                    @endif

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        {{ link_to_route('login', __('Login'), null, ['class' => 'nav-link']) }}
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        {{ link_to_route('register', __('common/action.create_company'), null, ['class' => 'nav-link']) }}
                                    </li>
                                @endif
                            @else
                                @if(Auth::check())
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            @can('manager-higher')
                                                <a class="dropdown-item" href="{{ route('user.create') }}">
                                                    {{ __('common/nav.user.create') }}
                                                </a>
                                            @endcan

                                            @can('admin-only')
                                                <a class="dropdown-item" href="{{ route('admin.edit') }}">
                                                    {{ __('common/nav.admin.edit') }}
                                                </a>
                                            @endcan

                                            @can('member-higher')
                                                <a class="dropdown-item" href="{{ route('user.edit', Auth::user()->id) }}">
                                                    {{ __('common/nav.user.edit') }}
                                                </a>
                                            @endcan

                                            @can('manager-higher')
                                                <a class="dropdown-item" href="{{ route('user.index', Auth::user()->id) }}">
                                                    {{ __('common/nav.user.delete') }}
                                                </a>
                                            @endcan

                                            @can('member-higher')
                                                <a class="dropdown-item" href="{{ route('company_group.index') }}">
                                                    {{ __('common/nav.company_group.index') }}
                                                </a>
                                            @endcan

                                            @can('company-higher')
                                                <a class="dropdown-item" href="{{ route('other_okr.index') }}">
                                                    {{ __('common/nav.other_okr.index') }}
                                                </a>
                                            @endcan

                                            @can('company-higher')
                                                <a class="dropdown-item" href="{{ route('slack.index') }}">
                                                    {{ __('common/nav.slack.index') }}
                                                </a>
                                            @endcan

                                            @can('member-higher')
                                                <a class="dropdown-item" href="{{ route('api_token.index') }}">
                                                    {{ __('common/nav.api_token.index') }}
                                                </a>
                                            @endcan

                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endif
                            @endguest
                        </ul>

                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
@stack('scripts')

</html>
