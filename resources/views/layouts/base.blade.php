<!DOCTYPE html>
<html lang="en" @yield('html-attributes')>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title : 'Helpmore' }}-Charity and Fundraising Template</title>

    <!--=====FAB ICON=======-->
    @if(isset($logo2))
        <link rel="shortcut icon" href="/img/logo/fav-logo2.png" type="image/x-icon">
    @elseif (isset($logo3))
        <link rel="shortcut icon" href="/img/logo/fav-logo3.png" type="image/x-icon">
    @elseif (isset($logo4))
        <link rel="shortcut icon" href="/img/logo/fav-logo4.png" type="image/x-icon">
    @elseif (isset($logo5))
        <link rel="shortcut icon" href="/img/logo/fav-logo5.png" type="image/x-icon">
    @else
        <link rel="shortcut icon" href="/img/logo/fav-logo1.png" type="image/x-icon">
    @endif

    <!--===== CSS LINK =======-->
    @vite(['resources/scss/main.scss'])

    @yield('css')

</head>

<body @yield('body-attributes')>

    @include('layouts.partials.preloader')

    @yield('header')

    @yield('content')

    <!--===== Scroll Top =======-->
    <div class="paginacontainer">
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
    </div>

    @yield('scripts')

    @vite(['resources/js/main.js'])
</body>

</html>
