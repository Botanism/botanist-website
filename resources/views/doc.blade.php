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
                        @if(isset($item['children']) && sizeof($item['children']) > 0)
                            <a href="/doc/{{ $key . '/' . array_keys($item['children'])[0] }}">{{$item['title']}} <i class="fas fa-chevron-left drop"></i></a>
                        @else
                            <a href="/doc/{{$key}}">{{$item['title']}}</a>
                        @endif

                        @if(isset($item['children']) && sizeof($item['children']) > 0)
                            <ul class="sub-doc">
                                @foreach($item['children'] as $sdKey => $subDirectory)
                                    <li{!! (isset($dirs[1]) && $dirs[1] == $sdKey)? ' class="active open"':'' !!}>
                                        @if(isset($subDirectory['children']) && sizeof($subDirectory['children']) > 0)
                                            <a href="/doc/{{ $key.'/'.$sdKey.'/'. array_keys($subDirectory['children'])[0] }}">{{$subDirectory['title']}} <i class="fas fa-chevron-left drop"></i></a>
                                        @else
                                            <a href="/doc/{{$key.'/'.$sdKey }}">{{$subDirectory['title']}}</a>
                                        @endif

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
                    $Parsedown->setSafeMode(false);
                    if(Str::contains(file_get_contents($file), '[----]')) {
                        $text = explode('[----]',file_get_contents($file))[1];
                    } else {
                        $text = file_get_contents($file);
                    }
                    echo $Parsedown->text(preg_replace("/<\\/?script(.|\\s)*?>/", "", $text));
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