@extends('layouts.master')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/prism.css') }}">
@endsection

@section('content')
    <div class="doc-main">
        <div class="doc-nav">
            <ul class="main-doc">
                @foreach($nav as $key => $item)
                    <li{!! ($dirs[0] == $key)? ' class="active open"':'' !!}>
                        <a href="/doc/{{$key}}">{{$item['title']}}{!! (isset($item['children']) && sizeof($item['children']) > 0)? '<i class="fas fa-chevron-left drop"></i>' : '' !!}</a>
                        @if(isset($item['children']) && sizeof($item['children']) > 0)
                            <ul class="sub-doc">
                                @foreach($item['children'] as $sdKey => $subDirectory)
                                    <li{!! (isset($dirs[1]) && $dirs[1] == $sdKey)? ' class="active open"':'' !!}>
                                        <a href="/doc/{{$key}}/{{$sdKey}}">{{$subDirectory['title']}}{!! (isset($subDirectory['children']) && sizeof($subDirectory['children']) > 0)? '<i class="fas fa-chevron-left drop"></i>' : '' !!}</a>
                                        @if(isset($subDirectory['children']) && sizeof($subDirectory['children']) > 0)
                                            <ul class="sub-sub-doc">
                                                @foreach($subDirectory['children'] as $ssdKey => $subSubDirectory)
                                                    <li{!! (isset($dirs[2]) && $dirs[2] == $ssdKey)? ' class="selected"':'' !!}><a href="/doc/{{$key}}/{{$sdKey}}/{{$ssdKey}}">{{$subSubDirectory['title']}}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="doc-container">
            <?php
                if ($state == 200) {
            ?>
                <div class="doc-breadcrumb">
                    Doc /
                    @php $pastDir = "/"; @endphp
                    @foreach($dirs as $dir)
                        <a href="/doc{{$pastDir . $dir}}/">{{$dir}}</a> /
                        @php $pastDir = $pastDir . $dir . '/'; @endphp
                    @endforeach
                </div>
            <?php
                    $Parsedown = new Parsedown();
                    $Parsedown->setSafeMode(true);
                    if(Str::contains(file_get_contents($file), '[----]')) {
                        echo $Parsedown->text(explode('[----]', file_get_contents($file))[1]);
                    } else {
                        echo $Parsedown->text(file_get_contents($file));
                    }
                } else {
            ?>
                   <div class="doc-404">
                       <span class="error">404</span>
                       <p class="error-comp">
                           <code>{{implode('/', $dirs)}}</code> <br />
                           {{$Lang->get('doc_404')}}
                       </p>
                   </div>
            <?php
                }
            ?>
        </div>
    </div>
@endsection

@section('additional_js')
    <script src="{{asset('js/prism.js')}}"></script>
@endsection