@extends('layouts.master')

@section('content')
    <div class="container login">
        <h1 class="page-title">{{$Lang->get('2FA')}}</h1>

        <form class="col-lg-6 offset-lg-3" method="post" action="{{route('check_2fa_token')}}">
            @csrf

            @if(session('wrong_token'))
                <div class="alert alert-error">{{$Lang->get('2FA_wrong_token')}}</div>
            @endif

            <div class="form-group">
                <input type="text" class="input-field @error('2fa') field-error @enderror" name="token_2fa" placeholder="{{$Lang->get('2FA_token')}}">
                <span class="form-error-return">@error('2fa') {{$message}} @enderror</span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-md btn-secondary">{{$Lang->get('validate')}}</button>
            </div>

            <div class="login-links">
                <a href="{{route('reset_2fa')}}">{{$Lang->get('2FA_app_lost')}}</a>
            </div>

        </form>
    </div>
@endsection