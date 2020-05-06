<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Botanist - Discord Bot</title>

        <link rel="stylesheet" href="{{ asset('css/fa.min.css') }}">

        @yield('additional_css')

        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>

    <body>
        <header>
            <div id="mobile-toggle-zone"><a id="mobile-menu-toggler"><i class="fas fa-bars"></i></a></div>
            <ul class="navbar">
                <div class="left-links">
                    <li><a href="{{route('home')}}">{{$Lang->get('navbar_home')}}</a></li>
                    <li><a href="{{route('faq')}}">{{$Lang->get('navbar_faq')}}</a></li>
                    <li><a href="{{route('doc')}}">{{$Lang->get('navbar_doc')}}</a></li>
                    <li><a href="" target="_blank">{{$Lang->get('navbar_get_botanist')}}</a></li>

                    <?php if(!Auth::check()): ?>
                        <li><a href="{{route('login')}}">{{$Lang->get('navbar_login')}}</a></li>
                    <?php else: ?>
                        <li><a href="{{route('dashboard')}}">{{$Lang->get('navbar_account')}}</a></li>
                    <?php endif; ?>
                </div>

                <li class="lang-select-zone">
                    <a class="lang-select"><img alt="{{$Lang->userLang()}} flag" src="{{asset('images/flags/'.$Lang->userLang().'.svg')}}"></a>
                    <ul class="lang-select-langs">
                        <li><a data-lang="fr"><img alt="fr flag" src="{{asset('images/flags/fr.svg')}}"> <span>Français</span></a></li>
                        <li><a data-lang="en"><img alt="en flag" src="{{asset('images/flags/en.svg')}}"> <span>English</span></a></li>
                    </ul>
                </li>
            </ul>
        </header>

        <div class="wrapper">
            @yield('content')
        </div>

        @if(!Cookie::get('accepted_cookies'))
            <div id="cookies-banner">
                <i class="fas fa-cookie-bite"></i>

                <span class="cookies-text">{{$Lang->get("cookies_short_text")}} {!! $Lang->get("cookies_more_info") !!}</span>

                <a class="btn btn-primary" id="accept-cookies">{{$Lang->get("cookies_okay")}}</a>
            </div>
        @endif

        <footer>
            <p class="license">{!! $Lang->get('footer_license') !!}</p>
            <p class="author">{!! $Lang->get('footer_author') !!}</p>

            <script src="{{asset('js/jquery.min.js')}}"></script>
            <script src="{{asset('js/main.js')}}"></script>
            @yield('additional_js')
        </footer>
    </body>
</html>