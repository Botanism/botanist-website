@extends('layouts.master')

@section('content')
    <div class="container login">
        <h1 class="page-title">{{$Lang->get('2FA_app_lost')}}</h1>

        <form class="col-lg-6 offset-lg-3" method="post" action="{{route('overstep_2fa')}}">
            @csrf

            @if(session('wrong_code'))
                <div class="alert alert-error">{{$Lang->get('2FA_wrong_reset_code')}}</div>
            @endif

            <div class="form-group">
                <input type="text" class="input-field @error('overstep_code_2fa') field-error @enderror" name="overstep_code_2fa" placeholder="{{$Lang->get('dashboard_2FA_overstep_code')}}" value="{{old('overstep_code_2fa')}}">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-md btn-secondary">{{$Lang->get('login_button')}}</button>
            </div>
        </form>
    </div>
@endsection