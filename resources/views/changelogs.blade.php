@extends('layouts.master')

@section('content')
    <div class="changelogs-main">
        <h1 class="page-title">{{$Lang->get("navbar_changelogs")}}</h1>

        <div class="container">
            <div id="changelogs-application-switch">
                <div id="changelogs-application-position"></div>
                <div id="changelogs-bot-switcher" class="active">{{$Lang->get("bot")}}</div>
                <div id="changelogs-website-switcher">{{$Lang->get("website")}}</div>
                <div id="changelogs-linker-switcher">{{$Lang->get("linker")}}</div>
            </div>
        </div>


        <div class="container versions active" id="bot-container">
            @if(sizeof($changelogs['bot']) > 0)
                @foreach($changelogs['bot'] as $botChangelogs)
                    <div class="version-container">
                        <a class="version-question"><i class="fas fa-plus"></i> {{$Lang->get('update')}} <span class="version-number">v{{$botChangelogs['version']}}</span><span class="version-date">{{$botChangelogs['date']}}</span></a>
                        <div class="version-answer">
                            <div class="version-answer-container">
                                {!! base64_decode($botChangelogs['content']); !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-warning m-0">{{str_replace(':app', 'le bot', $Lang->get('no_changelogs_for_this_app'))}}</div>
            @endif
        </div>

        <div class="container versions" id="website-container">
            @if(sizeof($changelogs['website']) > 0)
                @foreach($changelogs['website'] as $botChangelogs)
                    <div class="version-container">
                        <a class="version-question"><i class="fas fa-plus"></i> {{$Lang->get('update')}} <span class="version-number">v{{$botChangelogs['version']}}</span><span class="version-date">{{$botChangelogs['date']}}</span></a>
                        <div class="version-answer">
                            <div class="version-answer-container">
                                {!! base64_decode($botChangelogs['content']); !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-warning m-0">{{str_replace(':app', 'le site', $Lang->get('no_changelogs_for_this_app'))}}</div>
            @endif
        </div>

        <div class="container versions" id="linker-container">
            @if(sizeof($changelogs['linker']) > 0)
                @foreach($changelogs['linker'] as $botChangelogs)
                    <div class="version-container">
                        <a class="version-question"><i class="fas fa-plus"></i> {{$Lang->get('update')}} <span class="version-number">v{{$botChangelogs['version']}}</span><span class="version-date">{{$botChangelogs['date']}}</span></a>
                        <div class="version-answer">
                            <div class="version-answer-container">
                                {!! base64_decode($botChangelogs['content']); !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-warning m-0">{{str_replace(':app', 'linker API', $Lang->get('no_changelogs_for_this_app'))}}</div>
            @endif
        </div>
    </div>
@endsection
