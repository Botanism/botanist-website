@extends('layouts.dashboard')

@section('content')

    <div class="row">
        <div class="col-md-8">
            @if(session('2FA_reset'))
                <div class="alert alert-success">
                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                    <span>{{$Lang->get('2FA_reset')}}</span>
                </div>
            @endif

            @if(session('no_discord_account'))
                <div class="alert alert-warning">
                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                    <span>{{$Lang->get('no_discord_account')}}</span>
                </div>
            @endif

            @if(session('discord_account_already_linked'))
                <div class="alert alert-danger">
                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                    <span>{{$Lang->get('discord_account_already_linked')}}</span>
                </div>
            @endif

            @if(session('discord_account_successfully_linked'))
                <div class="alert alert-success">
                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                    <span>{{$Lang->get('discord_account_successfully_linked')}}</span>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="title">{{$Lang->get('dashboard_profile')}}</h4>
                </div>
                <div class="card-body">
                    @if(empty(Auth::user()->email))
                        <div class="alert alert-warning">
                            <span><i class="fas fa-exclamation-triangle"></i> {!! $Lang->get('dashboard_email_recommended') !!}</span>
                        </div>
                    @endif
                    @if(session('profile_updated'))
                        <div class="alert alert-success">
                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                            <span>{{$Lang->get('dashboard_profile_updated')}}</span>
                        </div>
                    @endif

                    <form method="post" action="{{route('update_profile')}}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label>{{$Lang->get('dashboard_pseudo')}}</label>
                                    <input type="text" name="pseudo" class="form-control @error('pseudo') is-invalid @enderror" placeholder="{{$Lang->get('dashboard_pseudo')}}" value="{{old('pseudo')??Auth::user()->pseudo}}">
                                    @error('pseudo') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{$Lang->get('dashboard_email')}}</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{$Lang->get('dashboard_email')}}" value="{{old('email')??Auth::user()->email}}">
                                    @error('email') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-fill btn-primary">{{$Lang->get('form_save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(empty(Auth::user()->discord_id))
                <div class="card">
                    <div class="card-header">
                        <h4 class="title">{{$Lang->get('dashboard_link_discord_title')}}</h4>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-primary" href="https://discordapp.com/api/oauth2/authorize?client_id=643858878529798166&redirect_uri={{urlencode(URL::to('/') . "/discord_login")}}&response_type=code&scope=identify%20email%20guilds"><i class="fab fa-discord"></i> {{$Lang->get('dashboard_link_discord')}}</a>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="title">{{$Lang->get('dashboard_profile_2FA')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if(!empty(Auth::user()->secret_2fa))
                                <div class="text-center">
                                    <p class="enabled-2fa">{{$Lang->get('2FA_enabled')}}</p>
                                    <img class="my-2" src="https://api.qrserver.com/v1/create-qr-code/?data=otpauth://totp/Botanist Website?secret={{Auth::user()->secret_2fa}}&size=150x150&ecc=M">
                                    <p>{{Auth::user()->secret_2fa}}</p>

                                    <a href="{{route('disable_2fa')}}" style="color: #cc2020;"><small>{{$Lang->get('disable_2FA')}}</small></a>
                                </div>
                            @else
                                <div id="recover-codes-2fa">
                                    <div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> {{$Lang->get('2FA_recover_warn')}}</div>
                                    <ul class="codes"></ul>
                                    <a class="btn btn-fill btn-primary" href="">{{$Lang->get('finish')}}</a>
                                </div>

                                <div id="zone-2fa">
                                    <p class="my-2"><span class="list-nb">1.</span> {{$Lang->get('2FA_scan_qr')}}</p>

                                    <img src=""/>

                                    <p><small>{{$Lang->get('2FA_qr_impossible')}} <span id="secret-code-2fa"></span></small></p>

                                    <p class="mt-3 mb-2"><span class="list-nb">2.</span> {{$Lang->get('2FA_enter_token')}}</p>

                                    <div class="form-group col-md-6 offset-md-3">
                                        <input type="text" class="form-control" placeholder="{{$Lang->get('2FA_token')}}" id="token-2fa">
                                    </div>

                                    <button class="btn btn-fill btn-primary" id="enable-check-2fa">{{$Lang->get('enable')}}</button>
                                </div>

                                <button id="enable-2fa" class="btn btn-fill btn-primary"><i class="fas fa-key"></i> {{$Lang->get('enable_2FA')}}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="title">{{$Lang->get('dashboard_profile_pass')}}</h4>
                </div>
                <div class="card-body">
                    @if(empty(Auth::user()->password))
                        <div class="alert alert-warning">
                            <span><i class="fas fa-exclamation-triangle"></i> {!! $Lang->get('dashboard_password_recommended') !!}</span>
                        </div>
                    @endif

                    @if(session('profile_pass_updated'))
                        <div class="alert alert-success">
                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                            <span>{{$Lang->get('dashboard_profile_pass_updated')}}</span>
                        </div>
                    @endif

                    @if(session('wrong_password'))
                        <div class="alert alert-danger">
                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                            <span>{{$Lang->get('dashboard_wrong_password')}}</span>
                        </div>
                    @endif

                    <form method="post" action="{{route('update_password')}}">
                        @csrf

                        @if(!empty(Auth::user()->password))
                            <div class="row">
                                <div class="col-md-6 pr-md-1">
                                    <div class="form-group">
                                        <label>{{$Lang->get('dashboard_current_pass')}}</label>
                                        <input type="password" name="old_pass" class="form-control @error('old_pass') is-invalid @enderror" placeholder="{{$Lang->get('dashboard_current_pass')}}">
                                        @error('old_pass') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label>{{$Lang->get('dashboard_new_pass')}}</label>
                                    <input type="password" name="new_pass" class="form-control @error('new_pass') is-invalid @enderror" placeholder="{{$Lang->get('dashboard_new_pass')}}">
                                    @error('new_pass') <div class="invalid-feedback">{!! $message !!}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{$Lang->get('dashboard_confirm_new_pass')}}</label>
                                    <input type="password" name="new_pass_confirm" class="form-control @error('new_pass') is-invalid @enderror" placeholder="{{$Lang->get('dashboard_confirm_new_pass')}}">
                                    @error('new_pass_confirm') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-fill btn-primary">{{$Lang->get('form_save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="title">{{$Lang->get('dashboard_danger_zone')}}</h4>
                    <a id="delete-account">{{$Lang->get('dashboard_delete_account')}}</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body">
                    <div class="author">
                        <div class="block block-one"></div>
                        <div class="block block-two"></div>
                        <div class="block block-three"></div>
                        <div class="block block-four"></div>
                        @if($discordUser)
                            <img class="avatar" src="https://cdn.discordapp.com/avatars/{{$discordUser->id . '/' . $discordUser->avatar}}.png" alt="...">
                        @else
                            <i class="fas fa-user"></i>
                        @endif

                        @if(!empty(Auth::user()->pseudo)) <h4 class="title mb-1">{{Auth::user()->pseudo}}</h4> @endif
                        @if(!empty($discordUser->username)) <h4>Discord: {{$discordUser->username}}</h4> @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{$Lang->get("dashboard_delete_account")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! $Lang->get("dashboard_delete_account_text"); !!}
            </div>
            <div class="modal-footer">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" id="confirm-account-delete" type="checkbox" value="" autocomplete="off">
                        {{$Lang->get("delete_understand")}}
                        <span class="form-check-sign">
                          <span class="check"></span>
                      </span>
                    </label>
                </div>
                <button type="button" class="btn btn-danger" id="oh-dear-we-are-in-trouble" disabled autocomplete="off">{{$Lang->get("delete_anyway")}}</button>
            </div>
        </div>
    </div>
</div>
@endsection