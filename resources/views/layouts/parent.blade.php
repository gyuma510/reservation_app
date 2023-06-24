<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    @include('layouts.header')
    @if (session('flash_message'))
        <div class="flash_message text-center py-3 my-0" style="background-color: #ccffcc; color: #004d00;">
            {{ session('flash_message') }}
        </div>
    @endif
    @if (session('flash_delete'))
        <div class="flash_message text-center py-3 my-0" style="background-color: #ffcce5; color: #800033;">
            {{ session('flash_delete') }}
        </div>
    @endif
    @yield('content')
    @include('layouts.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    @yield('scripts')
</body>
</html>
