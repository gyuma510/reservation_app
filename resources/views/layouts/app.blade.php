<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>宿泊予約サイト　管理者ページ</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/logo.png') }}" style="width: 50px; height: 50px;" alt="Logo">
                    みんシュク〜みんなの宿泊予約サイト〜　管理者ページ
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('plans.index')}}">{{ __('宿泊プラン一覧') }}</a>
                                    <a class="dropdown-item" href="{{ route('frames.index')}}">{{ __('予約枠一覧') }}</a>
                                    <a class="dropdown-item" href="{{ route('admin.contacts.index')}}">{{ __('お問合せ一覧') }}</a>
                                    <a class="dropdown-item" href="{{ route('reservations.index')}}" >{{ __('予約一覧') }}</a>
                                    <div class="dropdown-divider"></div>
                                    {{-- <a class="dropdown-item" href="{{ route('auth.passwords.reset', ['token' => $token]) }}" >{{ __('パスワード再設定') }}</a> --}}
                                    <a class="dropdown-item" href="{{ route('password.email')}}" >{{ __('メールアドレス変更') }}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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
        @if (session('flash_message'))
            <div class="flash_message bg-success text-center py-3 my-0">
                {{ session('flash_message') }}
            </div>
        @endif
        @if (session('flash_delete'))
            <div class="flash_message bg-danger text-center py-3 my-0">
                {{ session('flash_delete') }}
            </div>
        @endif
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
