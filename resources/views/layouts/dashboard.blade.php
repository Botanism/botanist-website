<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Botanist - Discord Bot</title>

        <link rel="stylesheet" href="{{ asset('css/fa.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard/black-dashboard.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard/dash-style.css') }}">
    </head>

    <body>
        <div class="wrapper">
            <div class="sidebar">
                <div class="sidebar-wrapper">
                    <ul class="nav">
                        <li{!! ($currRoute == "dashboard")? ' class="active"':'' !!}>
                            <a href="{{route('dashboard')}}">
                                <i class="fas fa-tachometer-alt"></i>
                                <p>{{$Lang->get('dashboard_profile')}}</p>
                            </a>
                        </li>

                        <li{!! ($currRoute == "servers")? ' class="active"':'' !!}>
                            <a href="{{route('servers')}}">
                                <i class="fas fa-server"></i>
                                <p>{{$Lang->get('dashboard_servers')}}</p>
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="/">
                                <i class="fas fa-globe-europe"></i>
                                <p>{{$Lang->get("dashboard_sidebar_goback")}}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="main-panel">
                <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
                    <div class="container-fluid">
                        <div class="navbar-wrapper">
                            <div class="navbar-toggle d-inline">
                                <button type="button" class="navbar-toggler">
                                    <span class="navbar-toggler-bar bar1"></span>
                                    <span class="navbar-toggler-bar bar2"></span>
                                    <span class="navbar-toggler-bar bar3"></span>
                                </button>
                            </div>
                            <a class="navbar-brand" href="{{route('home')}}">Botanist</a>
                        </div>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-bar navbar-kebab"></span>
                            <span class="navbar-toggler-bar navbar-kebab"></span>
                            <span class="navbar-toggler-bar navbar-kebab"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navigation">
                            <ul class="navbar-nav ml-auto">
                                <li class="dropdown nav-item">
                                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                        <div class="photo">
                                            @if($discordUser)
                                                <img src="https://cdn.discordapp.com/avatars/{{$discordUser->id . '/' . $discordUser->avatar}}.png" alt="Profile Photo">
                                            @else
                                                <i class="fas fa-user"></i>
                                            @endif
                                        </div>
                                        <b class="caret d-none d-lg-block d-xl-block"></b>
                                        <p class="d-lg-none">
                                            Log out
                                        </p>
                                    </a>
                                    <ul class="dropdown-menu dropdown-navbar">
                                        <li class="nav-link"><a href="{{route('dashboard')}}" class="nav-item dropdown-item">{{$Lang->get('dashboard_profile')}}</a></li>
                                        <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Settings</a></li>
                                        <li class="dropdown-divider"></li>
                                        <li class="nav-link"><a href="{{route('logout')}}" class="nav-item dropdown-item">{{$Lang->get('dashboard_logout')}}</a></li>
                                    </ul>
                                </li>

                                <li class="dropdown lang-select-zone">
                                    <a class="lang-select dropdown-toggle" data-toggle="dropdown" href="#"><img alt="{{$Lang->userLang()}} flag" src="{{asset('images/flags/'.$Lang->userLang().'.svg')}}"></a>
                                    <ul class="dropdown-menu dropdown-navbar lang-select-langs">
                                        <li class="nav-link"><a class="nav-item dropdown-item" data-lang="fr" href="#"><img alt="fr flag" src="{{asset('images/flags/fr.svg')}}"> <span>Français</span></a></li>
                                        <li class="nav-link"><a class="nav-item dropdown-item" data-lang="en" href="#"><img alt="en flag" src="{{asset('images/flags/en.svg')}}"> <span>English</span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <div class="content">
                    <ol class="breadcrumb">
                        <?php
                            $url = url()->current();
                            $url = explode('/', explode(URL::to('/').'/', $url)[1]);

                            $lastUrl = URL::to('/') . '/';
                            $i = 0;
                            foreach ($url as $link):
                                $lastUrl = $lastUrl . $link . '/';
                                $i++;
                        ?>
                                <li class="breadcrumb-item {{($i == sizeof($url))? "active" : ""}}">
                                    @if($i != sizeof($url)) <a href="{{$lastUrl}}"> @endif
                                        {{(is_numeric($link))? $serverInfo->name : $Lang->get('breadcrumb_' . $link)}}
                                    @if($i != sizeof($url)) </a> @endif
                                </li>
                        <?php
                            endforeach;
                        ?>
                    </ol>

                    @yield('content')
                </div>

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="copyright">{!! $Lang->get('dashboard_author') !!}</div>
                    </div>
                </footer>
            </div>
        </div>

        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/dashboard/bootstrap.min.js')}}"></script>

        <script src="{{asset('js/dashboard/dash-main.js')}}"></script>

        <script src="{{asset('js/dashboard/plugins/chartjs.min.js')}}"></script>
        <script src="{{asset('js/dashboard/plugins/bootstrap-notify.js')}}"></script>
        <script src="{{asset('js/dashboard/black-dashboard.min.js?v=1.0.0')}}"></script>
    </body>
</html>