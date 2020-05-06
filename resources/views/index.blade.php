@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="hello">
            <h1 class="bot-name">Botanist</h1>
            <img alt="botanist logo" class="fluid-img w-50" src="{{asset('images/logo.png')}}">

            <a href="" class="btn btn-lg btn-primary"><i class="fab fa-discord"></i> {!! $Lang->get('add_botanist') !!}</a>
        </div>

        <div class="row modularity">
            <div class="col-10 offset-1 col-sm-6 offset-sm-0 col-lg-7">
                <h2>{{$Lang->get('modularity')}}</h2>
                <p>{!! $Lang->get('modularity_desc') !!}</p>
            </div>
            <div class="col-10 offset-1 col-sm-6 offset-sm-0 col-lg-5 text-center p-lr-1">
                <img alt="modularity" class="fluid-img" src="{{asset('images/extensions.png')}}">
            </div>
        </div>

        <div class="row opensource">
            <div class="col-10 offset-1 col-sm-6 offset-sm-0 col-lg-4 image-container">
                <i class="fab fa-osi"></i>
            </div>

            <div class="col-10 offset-1 col-sm-6 offset-sm-0 col-lg-8">
                <h2>{{$Lang->get('opensource')}}</h2>
                <p>{!! $Lang->get('opensource_desc') !!}</p>
            </div>
        </div>

        <div class="row extensions">
            <div class="col-12 text-center">
                <h2>{{$Lang->get('extensions')}}</h2>

                <p>{!! $Lang->get('extensions_desc') !!}</p>

                <div class="extensions-box row">
                    {{-- TODO : TRY TO USE IMAGE WITH THE SAME RATIO + LIGHTWEIGHT :D --}}
                    <div class="extension col-10 offset-1 col-xs-8 offset-xs-2 col-sm-6 offset-sm-0 col-lg-4">
                        <h3>{{$Lang->get('ext_slapping')}}</h3>
                        <img class="fluid-img" alt="extension slapping" src="{{asset('images/slapping.png')}}">
                        <p>{!! $Lang->get('ext_slapping_desc') !!}</p>
                    </div>
                    <div class="extension col-10 offset-1 col-xs-8 offset-xs-2 col-sm-6 offset-sm-0 col-lg-4">
                        <h3>{{$Lang->get('ext_poll')}}</h3>
                        <img class="fluid-img" alt="extension poll" src="{{asset('images/poll.png')}}">
                        <p>{!! $Lang->get('ext_poll_desc') !!}</p>
                    </div>
                    <div class="extension col-10 offset-1 col-xs-8 offset-xs-2 col-sm-6 offset-sm-0 col-lg-4">
                        <h3>{{$Lang->get('ext_embedding')}}</h3>
                        <img class="fluid-img" alt="extension embedding" src="{{asset('images/embedding.png')}}">
                        <p>{!! $Lang->get('ext_embedding_desc') !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection