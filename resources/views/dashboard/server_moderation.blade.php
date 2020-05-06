@extends('layouts.dashboard')

@section('content')
    <div class="settings-parent container">
        <div class="card">
            <div class="card-header">
                <h3 class="title"><em>{{$serverInfo->name}}</em> - {{$Lang->get('dashboard_conf_moderation')}}</h3>
            </div>

            <div class="card-body">
                <h3>{{$Lang->get('mute')}}</h3>

                <div class="form-group col-lg-4 col-md-7">
                    <label>{{$Lang->get("mute_duration")}}</label>
                    <input type="number" min="1" id="spam_duration" class="form-control" placeholder="{{$Lang->get("mute_duration")}}">
                </div>
            </div>
        </div>

        <div class="card">
             <div class="card-body">
                <h3>{{$Lang->get('warnings')}}</h3>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3>{{$Lang->get('reports')}}</h3>


            </div>
        </div>
    </div>
@endsection