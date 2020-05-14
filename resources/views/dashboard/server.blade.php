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

            <div class="row">
                <div class="col-12">
                    <a id="remove-server" data-toggle="modal" data-target="#remove-server-modal">{{$Lang->get('dashboard_conf_remove_server')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="remove-server-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$Lang->get('dashboard_conf_remove_server')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! $Lang->get('dashboard_conf_remove_server_warning') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{$Lang->get('cancel')}}</button>
                    <a href="{{route('server_conf_remove_server', $srvId)}}" class="btn btn-danger">{{$Lang->get('remove')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection