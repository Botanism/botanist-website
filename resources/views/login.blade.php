@extends('layouts.master')

@section('content')
    <div class="container login">
        <h1 class="page-title">{{$Lang->get('login')}}</h1>

        <form class="col-lg-6 offset-lg-3" method="post" action="{{route('send_login')}}">
            @csrf

            @if(session('wrong_credentials'))
                <div class="alert alert-error">{{$Lang->get('wrong_credentials')}}</div>
            @endif

            <div class="form-group">
                <input type="text" class="input-field @error('login') field-error @enderror" name="login" placeholder="{{$Lang->get('field_login')}}" value="{{(!empty(session('old_login_input')))? session('old_login_input') : old('login')}}">
                <span class="form-error-return">@error('login') {{$message}} @enderror</span>
            </div>

            <div class="form-group">
                <input type="password" class="input-field @error('password') field-error @enderror" name="password" placeholder="{{$Lang->get('field_password')}}">
                <span class="form-error-return">@error('password') {{$message}} @enderror</span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-md btn-secondary">{{$Lang->get('login_button')}}</button>
            </div>

            <p class="split-or">{{$Lang->get('or')}}</p>

            <a class="btn btn-primary discord-login" href="https://discordapp.com/api/oauth2/authorize?client_id=643858878529798166&redirect_uri=http%3A%2F%2Flocalhost%3A8000%2Fdiscord_login&response_type=code&scope=identify%20email%20guilds">{!! $Lang->get('login_using_discord') !!}</a>

            <div class="login-links">
                <a href="{{route('register')}}">{{$Lang->get('no_account')}}</a>
                <a href="{{route('lost_password')}}">{{$Lang->get('lost_password')}}</a>
            </div>

        </form>
    </div>
@endsection