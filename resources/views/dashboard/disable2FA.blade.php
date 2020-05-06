@extends('layouts.dashboard')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">{{$Lang->get('disable_2FA')}}</h4>
                </div>

                <div class="card-body">
                    <form method="post" action="{{route('remove_2fa')}}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                @if(session('wrong_code'))
                                    <div class="alert alert-danger">
                                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                                        <span>{{$Lang->get('2FA_wrong_reset_code')}}</span>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label>{{$Lang->get('dashboard_2FA_reset_code')}}</label>
                                    <input type="text" name="reset_code_2fa" class="form-control @error('reset_code_2fa') is-invalid @enderror" placeholder="{{$Lang->get('dashboard_2FA_reset_code')}}" value="{{old('pseudo')}}">
                                    <small>{{$Lang->get('dashboard_2FA_reset_code_info')}}</small>
                                    @error('reset_code_2fa') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-fill btn-primary">{{$Lang->get('validate')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection