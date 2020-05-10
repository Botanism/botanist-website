@extends('layouts.dashboard')

@section('content')
    @if(session('add_bot_error'))
        <div class="alert alert-warning">
                <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                <span>{{$Lang->get(session('add_bot_error'))}}</span>
        </div>
    @endif
    @if(session('added_server'))
        <div class="alert alert-success">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
            <span>{{$Lang->get('dashboard_server_added')}}</span>
        </div>
    @endif
    @if(session('bot_link_failed'))
        <div class="alert alert-warning">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
            <span>{{$Lang->get('bot_link_failed')}}</span>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h4 class="title">{{$Lang->get('dashboard_my_servers')}}</h4>
        </div>
        <div class="card-body added-servers row">
            @if(sizeof($myServers) == 0)
                <div class="alert alert-info"><span>{{$Lang->get('dashboard_no_server_bot')}}</span></div>
            @endif
            @foreach($myServers as $myServer)
                <?php if(!isset($servers[$myServer->server_id])) continue; ?>
                <a href="{{route('edit_server', $myServer->id)}}" class="col-lg-2 col-md-3 col-sm-4 col-6 server-thumbnail">
                    @if($servers[$myServer->server_id]->icon)
                        <img src="https://cdn.discordapp.com/icons/{{$myServer->server_id}}/{{$servers[$myServer->server_id]->icon}}.png?size=64">
                    @else
                        <div class="srv-fake-logo">
                            @php
                                $nameArray = explode(' ', $servers[$myServer->server_id]->name);
                                $name = '';
                                foreach ($nameArray as $s) { $name .= $s[0]; }
                            @endphp
                            <span>{!! substr($name, 0, 3) !!}</span>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                    <span class="server-name">{{$servers[$myServer->server_id]->name}}</span>
                </a>
                <?php unset($servers[$myServer->server_id]); ?>
            @endforeach

            <div class="add-server col-12 mt-4">
                <h4 class="title">{{$Lang->get('dashboard_botanist_already_on_server')}}</h4>

                @error('server_id')
                    <div class="alert alert-danger col-lg-6">
                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                        <span>{{$message}}</span>
                    </div>
                @enderror

                <form method="post" action="" class="row">
                    @csrf

                    <div class="form-group col-lg-6 col-md-8">
                        <div class="input-group">
                            <input type="text" name="server_id" class="form-control d-inline-block" placeholder="{{$Lang->get('dashboard_add_server_id')}}">
                            <div class="input-group-append">
                                <button class="btn btn-warning animation-on-hover m-0" style="transform: unset!important;">{{$Lang->get("form_add")}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="title">{{$Lang->get('dashboard_servers')}}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($servers as $server)
                    <?php if(!$server->owner && !($server->permissions & 0x8)) continue; ?>
                    <a href="https://discordapp.com/api/oauth2/authorize?client_id=564216916613267456&redirect_uri={{route('added_server')}}&response_type=code&scope=bot&permissions=8&guild_id={{$server->id}}" class="col-lg-2 col-md-3 col-sm-4 col-6 server-thumbnail">
                        @if($server->icon)
                            <img src="https://cdn.discordapp.com/icons/{{$server->id}}/{{$server->icon}}.png?size=64">
                        @else
                            <div class="srv-fake-logo">
                                @php
                                    $nameArray = explode(' ', $server->name);
                                    $name = '';
                                    $trans = ['Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'Ğ'=>'G', 'İ'=>'I', 'Ş'=>'S', 'ğ'=>'g', 'ı'=>'i', 'ş'=>'s', 'ü'=>'u', 'ă'=>'a', 'Ă'=>'A', 'ș'=>'s', 'Ș'=>'S', 'ț'=>'t', 'Ț'=>'T'];
                                    foreach ($nameArray as $s) { $name .= strtr($s, $trans)[0]; }
                                @endphp
                                <span>{!! substr($name, 0, 3) !!}</span>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                        <span class="server-name">{{$server->name}}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection