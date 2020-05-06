@extends('layouts.dashboard')

@section('content')
    <div class="settings-parent container">
        <input type="hidden" id="server-id" value="{{$id}}">
        <div class="card">
            <div class="card-header">
                <h3 class="title"><em>{{$serverInfo->name}}</em> - {{$Lang->get('dashboard_conf_general')}}</h3>
            </div>

            <div class="card-body">
                <h3>{{$Lang->get('language')}}</h3>
                <div class="form-group col-lg-4">
                    <label>{{$Lang->get("language")}}</label>
                    <select id="language" class="form-control settings-option" autocomplete="off">
                        <option value="en" {{ ($serverConfig->lang == "en")? 'selected' : '' }}>{{$Lang->get("lang_en")}}</option>
                        <option value="fr" {{ ($serverConfig->lang == "fr")? 'selected' : '' }}>{{$Lang->get("lang_fr")}}</option>
                        <option value="tk" {{ ($serverConfig->lang == "tk")? 'selected' : '' }}>{{$Lang->get("lang_tk")}}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3>{{$Lang->get('messages')}}</h3>

                <div class="form-group col-lg-6">
                    <label>{{$Lang->get("welcome_message")}}</label>
                    <textarea class="form-control settings-option" id="welcome_message" autocomplete="off" placeholder="{{$Lang->get('welcome_message')}}">{{$serverConfig->messages->welcome}}</textarea>
                    <small>{{$Lang->get("messages_info")}}</small>
                </div>

                <div class="form-group col-lg-6 mt-5">
                    <label>{{$Lang->get("goodbye_message")}}</label>
                    <textarea class="form-control settings-option" id="goodbye_message" autocomplete="off" placeholder="{{$Lang->get('goodbye_message')}}">{{$serverConfig->messages->goodbye}}</textarea>
                    <small>{{$Lang->get("messages_info")}}</small>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3>{{$Lang->get('channels')}}</h3>

                <div class="form-group col-lg-6">
                    <label>{{$Lang->get("channel_report")}}</label>
                    <select id="channel_report" class="form-control settings-option" autocomplete="off">
                        <option value="">{{$Lang->get("disabled")}}</option>

                        <?php
                        foreach($channels as $channel):
                             if($channel->type != 0) continue;
                        ?>
                            <option value="{{$channel->id}}" {{($channel->id==$serverConfig->commode->reports_chan)? "selected" : ""}}>{{$channel->name}}</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-lg-6">
                    <label>{{$Lang->get("channel_poll")}}</label>
                    <select id="channel_poll" class="form-control settings-option" multiple autocomplete="off">
                        <option value=""{{(sizeof($serverConfig->poll_channels)==0)? "selected":""}}>{{$Lang->get("disabled")}}</option>

                        <?php
                        foreach($channels as $channel):
                            if($channel->type != 0) continue;
                        ?>
                            <option value="{{$channel->id}}" {{(in_array($channel->id, $serverConfig->poll_channels))? "selected" : ""}}>{{$channel->name}}</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-lg-6">
                    <label>{{$Lang->get("channel_todo")}}</label>
                    <select id="channel_todo" class="form-control settings-option" autocomplete="off" disabled>
                        <option value="">{{$Lang->get("disabled")}}</option>

                        <?php
                        foreach($channels as $channel):
                            if($channel->type != 0) continue;
                        ?>
                            <option value="{{$channel->id}}" {{($channel->id==$serverConfig->todo_channel)? "selected" : ""}}>{{$channel->name}}</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-lg-6">
                    <label>{{$Lang->get("channel_advertisement")}}</label>
                    <select id="channel_advertisement" class="form-control settings-option" autocomplete="off">
                        <option value="">{{$Lang->get("disabled")}}</option>

                        <?php
                        foreach($channels as $channel):
                        if($channel->type != 0) continue;
                        ?>
                        <option value="{{$channel->id}}" {{($channel->id==$serverConfig->advertisement)? "selected" : ""}}>{{$channel->name}}</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3>{{$Lang->get('roles')}}</h3>

                <div class="form-group col-lg-6">
                    <label>{{$Lang->get("role_manager")}}</label>
                    <select id="role_manager" class="form-control settings-option" multiple autocomplete="off">
                        <option value="" {{(sizeof($serverConfig->roles->manager)==0)? "selected":""}}>{{$Lang->get("disabled")}}</option>

                        @foreach($roles as $role)
                            <option value="{{$role->id}}" {{(in_array($role->id, $serverConfig->roles->manager))? "selected" : ""}}>{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-lg-6">
                    <label>{{$Lang->get("role_admin")}}</label>
                    <select id="role_admin" class="form-control settings-option" multiple autocomplete="off">
                        <option value=""{{(sizeof($serverConfig->roles->admin)==0)? "selected":""}}>{{$Lang->get("disabled")}}</option>

                        @foreach($roles as $role)
                            <option value="{{$role->id}}" {{(in_array($role->id, $serverConfig->roles->admin))? "selected" : ""}}>{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-lg-6">
                    <label>{{$Lang->get("role_free")}}</label>
                    <select id="role_free" class="form-control settings-option" multiple autocomplete="off">
                        <option value=""{{(sizeof($serverConfig->free_roles)==0)? "selected":""}}>{{$Lang->get("disabled")}}</option>

                        @foreach($roles as $role)
                            <option value="{{$role->id}}" {{(in_array($role->id, $serverConfig->free_roles))? "selected" : ""}}>{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div id="settings-saver">
        <p>{{$Lang->get('settings_edited')}}</p>
        <button id="save-settings" class="btn btn-success animation-on-hover">{{$Lang->get('settings_save')}}</button>
    </div>
@endsection