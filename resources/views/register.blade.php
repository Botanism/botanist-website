@extends('layouts.master')

@section('content')
    <div class="container login">
        <h1 class="page-title">{{$Lang->get('register')}}</h1>

        <form class="col-lg-6 offset-lg-3" method="post" action="{{route('send_register')}}">
            @csrf

            <div class="form-group">
                <input type="text" class="input-field @error('pseudo') field-error @enderror" name="pseudo" placeholder="{{$Lang->get('field_pseudo')}}" value="{{old('pseudo')}}">
                <span class="form-error-return">@error('pseudo') {{$message}} @enderror</span>
            </div>

            <div class="form-group">
                <input type="email" class="input-field @error('email') field-error @enderror" name="email" placeholder="{{$Lang->get('field_email')}}*" value="{{old('email')}}">
                <span class="form-error-return">@error('email') {{$message}} @enderror</span>
            </div>

            <div class="form-group">
                <input type="password" class="input-field @error('password') field-error @enderror" name="password" placeholder="{{$Lang->get('field_password')}}*" autocomplete="off">
                <span class="form-error-return">@error('password') {!! $message !!} @enderror</span>
            </div>

            <div class="form-group">
                <input type="password" class="input-field @error('conf_password') field-error @enderror" name="conf_password" placeholder="{{$Lang->get('field_confirm_password')}}*" autocomplete="off">
                <span class="form-error-return">@error('conf_password') {{$message}} @enderror</span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-md btn-secondary">{{$Lang->get('register_button')}}</button>
            </div>

            <p class="split-or">{{$Lang->get('or')}}</p>

            <a class="btn btn-primary discord-login" href="https://discordapp.com/api/oauth2/authorize?client_id=643858878529798166&redirect_uri={{urlencode(URL::to('/') . "/discord_login")}}&response_type=code&scope=identify%20email%20guilds">{!! $Lang->get('login_using_discord') !!}</a>

            <div class="login-links">
                <a href="{{route('login')}}">{{$Lang->get('have_account')}}</a>
            </div>
        </form>
    </div>
@endsection