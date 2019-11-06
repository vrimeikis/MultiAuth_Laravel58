<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        /* these styles will animate bootstrap alerts. */
        .alert {
            z-index: 99;
            top: 60px;
            right: 18px;
            min-width: 30%;
            position: fixed;
            animation: slide 0.5s forwards;
        }

        @keyframes slide {
            100% {
                top: 30px;
            }
        }

        @media screen and (max-width: 668px) {
            .alert { /* center the alert on small screens */
                left: 10px;
                right: 10px;
            }
        }
    </style>

</head>
<body>
<div id="app">
    @include('inc.admin_navbar')

    <main class="py-4">
        @yield('content')
    </main>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

<script>
    $(document).ready(function () {
        setTimeout(function () {
            $(".alert").alert('close');
        }, 3000);
    });
</script>
</body>
</html>
