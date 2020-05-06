@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="title">{{$Lang->get('dashboard_my_server')}} - <em>{{$serverInfo->name}}</em></h4>
        </div>
        <div class="card-body">
            <div class="configs-box row">
                <div class="config-cat-container col-xl-3 col-lg-4 col-sm-6">
                    <a href="{{route('server_conf_general', $srvId)}}" class="config-cat row">
                        <div class="col-lg-4 col-3">
                            <img src="{{asset('images/config/general.svg')}}">
                            {{-- <div>Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a></div> --}}
                        </div>

                        <div class="col-lg-8 col-9">
                            <span class="config-cat-name">{{ $Lang->get('dashboard_conf_general') }}</span>
                        </div>
                    </a>
                </div>

                <div class="config-cat-container col-xl-3 col-lg-4 col-sm-6">
                    <a href="{{route('server_conf_moderation', $srvId)}}" class="config-cat row">
                        <div class="col-lg-4 col-3">
                            <img src="{{asset('images/config/moderation.svg')}}">
                            {{-- Icons made by <a href="https://www.flaticon.com/authors/itim2101" title="itim2101">itim2101</a> --}}
                        </div>

                        <div class="col-lg-8 col-9">
                            <span class="config-cat-name">{{ $Lang->get('dashboard_conf_moderation') }}</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection