<?php


namespace App\Http\Controllers;

use App\codes2fa;
use App\Http\Controllers\DiscordController as Discord;
use \App\Http\Controllers\LangController as Lang;
use \App\Http\Controllers\BotController as Bot;
use \App\Http\Controllers\TwoFAuthController as TwoFAuth;
use App\Server;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController
{
    public function acceptCookies () {
        return response(0)->cookie('accepted_cookies', true, 60*24*30*12);
    }

    public function login () {
        if(Auth::check()) return redirect()->to(route('dashboard'));
        return view('login');
    }

    public function register () {
        if(Auth::check()) return redirect()->to(route('dashboard'));
        return view('register');
    }

    public function check2FA () {
        if(!session('2fa_infos')) {
            return redirect()->to(route('login'));
        }  else {
            session()->flash('2fa_infos', session('2fa_infos'));
        }

        return view('2fa');
    }

    public function check2FAToken (Request $request) {
        if(!session('2fa_infos')) return redirect()->to(route('login'));

        $twoFA = new TwoFAuth();

        $goodToken = $twoFA->verifyCode(session('2fa_infos')['secret'], $request->token_2fa, 1);

        if($goodToken) {
            Auth::loginUsingId(session('2fa_infos')['id']);
            return redirect()->to(route('dashboard'));
        } else {
            session()->flash('2fa_infos', session('2fa_infos'));
            session()->flash('wrong_token', true);
            return redirect()->to(route('check_2fa'));
        }
    }

    public function signIn (Request $request) {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ],
        [
            'login.required' => (new Lang())->get('field_login_required'),
            'login.max' => (new Lang())->get('field_login_too_long'),
            'password.required' => (new Lang())->get('field_password_required')
        ]);

        $column = (filter_var($request->login, FILTER_VALIDATE_EMAIL))? 'email' : 'pseudo';

        if(Auth::once([$column => $request->login, 'password' => $request->password])) {
            if (empty(Auth::user()->secret_2fa)) {
                Auth::loginUsingId(Auth::id());
                return redirect()->to(route('dashboard'));
            } else {
                session()->flash('2fa_infos', ['id' => Auth::user()->id, 'secret' => Auth::user()->secret_2fa]);
                return redirect()->to(route('check_2fa'));
            }
        } else {
            session()->flash('wrong_credentials', true);
            session()->flash('old_login_input', $request->login);
            return redirect()->back();
        }
    }

    public function signUp (Request $request) {
        $request->validate([
            'pseudo' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'regex:/^(?=.*[A-Z])+(?=.*[!@#$&*%^])+(?=.*[0-9])+(?=.*[a-z])+.{9,}$/'],
            'conf_password' => ['required', 'same:password']
        ],
        [
            'pseudo.max' => (new Lang())->get('field_pseudo_too_long'),
            'email.required' => (new Lang())->get('field_email_required'),
            'email.email' => (new Lang())->get('field_email_wrong_format'),
            'email.unique' => (new Lang())->get('field_email_not_unique'),
            'password.required' => (new Lang())->get('field_password_required'),
            'password.regex' => (new Lang())->get('field_password_rules'),
            'conf_password.required' => (new Lang())->get('field_confirm_password_required'),
            'conf_password.same' => (new Lang())->get('field_confirm_password_not_same')
        ]);

        (new User)::insert([
            'pseudo' => (empty($request->pseudo))? null : $request->pseudo,
            'discord_id' => null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'access_token' => null,
            'refresh_token' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null
        ]);

        session()->flash('account_created', true);
        return redirect()->to(route('dashboard'));
    }

    public function updateProfile (Request $request) {
        $emailRequirements = ['email'];
        if($request->email != Auth::user()->email)
            $emailRequirements[] = 'unique:users';
        $emailRequirements[] = (empty(Auth::user()->discord_id))? 'required' : 'nullable';


        $request->validate([
            'pseudo' => ['nullable', 'string', 'max:255'],
            'email' => $emailRequirements
        ],
        [
            'pseudo.max' => (new Lang())->get('field_pseudo_too_long'),
            'email.required' => (new Lang())->get('field_email_required'),
            'email.email' => (new Lang())->get('field_email_wrong_format'),
            'email.unique' => (new Lang())->get('field_email_not_unique')
        ]);

        (new User)->where('id', '=', Auth::user()->id)->first()->update([
            'pseudo' => $request->pseudo,
            'email' => $request->email
        ]);

        session()->flash('profile_updated', true);
        return redirect()->back();
    }

    public function updatePassword (Request $request) {
        $request->validate([
            'new_pass' => ['required', 'regex:/^(?=.*[A-Z])+(?=.*[!@#$&*%^])+(?=.*[0-9])+(?=.*[a-z])+.{9,}$/'],
            'new_pass_confirm' => ['required', 'same:new_pass']
        ],
        [
            'new_pass.required' => (new Lang())->get('field_password_required'),
            'new_pass.regex' => (new Lang())->get('field_password_rules'),
            'new_pass_confirm.required' => (new Lang())->get('field_confirm_password_required'),
            'new_pass_confirm.same' => (new Lang())->get('field_confirm_password_not_same')
        ]);


        if(!empty(Auth::user()->password)) {
            if(!Hash::check($request->old_pass, Auth::user()->password)) {
                session()->flash('wrong_password', true);
                return redirect()->back();
            }
        }

        (new User)->where('id', '=', Auth::user()->id)->first()->update([
            'password' => Hash::make($request->new_pass)
        ]);

        session()->flash('profile_pass_updated', true);
        return redirect()->back();
    }

    public function servers () {
        if(empty(Auth::user()->discord_id)) {
            session()->flash('no_discord_account', true);
            return redirect()->to(route('dashboard'));
        }

        usleep(300000); // To avoid problem with the Discord API (300ms)

        $Discord = new Discord();
        $myServers = (new Server())->where('user_id', Auth::user()->id)->get();
        $getServers = json_decode($Discord->discordApiCall($Discord->apiBaseUrl.'/guilds', false, Auth::user()->access_token));

        $servers = [];
        $serversId = [];
        foreach ($getServers as $srv) {
            $servers[$srv->id] = $srv;
            $serversId[] = $srv->id;
        }

        $alreadyUsedServers = (new Server())->select('server_id')->where('user_id', '<>', Auth::id())->whereIn('server_id', $serversId)->get();

        foreach ($alreadyUsedServers as $server) {
            unset($servers[$server->server_id]);
        }

        return view('dashboard.servers', compact('servers', 'myServers'));
    }

    public function addServer(Request $request) {
        $request->validate([
            'server_id' => ['required', 'digits:18']
        ],
        [
            'server_id.required' => (new Lang())->get('field_server_id_required'),
            'server_id.digits' => (new Lang())->get('field_server_id_not_correct')
        ]);

        $Discord = new Discord();
        $getServers = json_decode($Discord->discordApiCall($Discord->apiBaseUrl.'/guilds', false, Auth::user()->access_token));
        $servers = [];
        foreach ($getServers as $srv) {
            $servers[$srv->id] = $srv;
        }

        usleep(300000); // To avoid problem with the Discord API (300ms)

        if(!isset($servers[$request->server_id])) {
            session()->flash('add_bot_error', 'dashboard_user_not_on_server');
           session()->flash('test', 'dashboard_user_not_on_server');
            return redirect()->to(route('servers'));
        }
        if(!($servers[$request->server_id]->permissions & 0x8)) {
            session()->flash('add_bot_error', 'dashboard_user_not_admin');
            return redirect()->to(route('servers'));
        }

        if((new Bot())->hasBot($request->server_id)) {
            if ((new Server())->where('server_id', $request->server_id)->doesntExist()) {
                (new Server())->insert([
                    'server_id' => $request->server_id,
                    'user_id' => Auth::id()
                ]);
                session()->flash('added_server', true);
                return redirect()->to(route('servers'));
            } else {
                session()->flash('add_bot_error', 'dashboard_server_already_exists');
                return redirect()->to(route('servers'));
            }
        } else {
            session()->flash('add_bot_error', 'dashboard_bot_not_on_server');
            return redirect()->to(route('servers'));
        }
    }

    public function addedServer() {
        if(!isset($_GET['code'], $_GET['guild_id'])) return redirect()->to(route('servers'));

        $Discord = new Discord();
        $getServers = json_decode($Discord->discordApiCall($Discord->apiBaseUrl.'/guilds', false, Auth::user()->access_token));
        $servers = [];
        foreach ($getServers as $srv) {
            $servers[$srv->id] = $srv;
        }

        usleep(300000); // To avoid problem with the Discord API (300ms)

        if(!isset($servers[$_GET['guild_id']])) {
            session()->flash('add_bot_error', 'dashboard_user_not_on_server');
            return redirect()->to(route('servers'));
        }
        if(!($servers[$_GET['guild_id']]->permissions & 0x8)) {
            session()->flash('add_bot_error', 'dashboard_user_not_admin');
            return redirect()->to(route('servers'));
        }


        if((new Bot())->hasBot($_GET['guild_id'])) {
            if ((new Server())->where('server_id', $_GET['guild_id'])->doesntExist()) {
                (new Server())->insert([
                    'server_id' => $_GET['guild_id'],
                    'user_id' => Auth::user()->id
                ]);
                session()->flash('added_server', true);
                return redirect()->to(route('servers'));
            } else {
                session()->flash('add_bot_error', 'dashboard_server_already_exists');
                return redirect()->to(route('servers'));
            }
        } else {
            session()->flash('add_bot_error', 'dashboard_bot_not_on_server');
            return redirect()->to(route('servers'));
        }
    }

    public function editServer($id) {
        $server = (new Server())->where('id', $id)->get()->first();

        $Discord = new Discord();
        $serverInfo = json_decode($Discord->discordApiCall($Discord->apiGuildBaseUrl . $server->server_id, false, false,true));

        return view('dashboard.server', ['srvId' => $id, 'serverInfo' => $serverInfo]);
    }

    public function removeServer($id) {
        (new Server())->where('id', '=', $id)->get()->first()->delete();

        session()->flash("server_removed", true);

        return redirect()->to(route('servers'));
    }

    public function updateConfiguration ($id, Request $request) {
        $request = json_decode($request->conf, true);

        $Lang = new Lang;

        $validation = Validator::make($request, [
            'language' => ['nullable', 'string', 'size:2'],
            'welcome_message' => ['nullable', 'string', 'max:1950'],
            'goodbye_message' => ['nullable', 'string', 'max:1950'],
            'channel_report' => ['nullable', 'digits:18'],
            'channel_todo' => ['nullable', 'digits:18'],
            'channel_advertisement' => ['nullable', 'digits:18'],
            'channel_poll.*' => ['nullable', 'digits:18'],
            'role_manager.*' => ['nullable', 'digits:18'],
            'role_admin.*' => ['nullable', 'digits:18'],
            'role_free.*' => ['nullable', 'digits:18']
        ],
        [
            'language.size' =>  $Lang->get('language_wrong_size'),
            'welcome_message.max' =>  $Lang->get('welcome_too_long'),
            'goodbye_message.max' =>  $Lang->get('goodbye_too_long'),
            'channel_report.digits' =>  $Lang->get('channels_wrong_size'),
            'channel_todo.digits' =>  $Lang->get('channels_wrong_size'),
            'channel_advertisement.digits' =>  $Lang->get('channels_wrong_size'),
            'channel_poll.*.digits' =>  $Lang->get('channels_wrong_size'),
            'role_manager.*.digits' =>  $Lang->get('roles_wrong_size'),
            'role_admin.*.digits' =>  $Lang->get('roles_wrong_size'),
            'role_free.*.digits' =>  $Lang->get('roles_wrong_size')
        ]);

        if ($validation->fails()) {
            return json_encode(["errors" => $validation->messages()]);
        } else {
            $serverInfos = (new Server())->where("id", "=", $id)->get()->first();

            if($serverInfos->user_id != Auth::id()) return response()->isForbidden();

            $response = (new  BotController())->updateConfig($serverInfos->server_id, $request);

            return json_encode(["errors" => [], "response" => $response]);
        }
    }

    public function editServerGeneral ($id) {
        $server = (new Server())->where('id', $id)->get()->first();

        $serverId = $server->server_id;

        $Discord = new Discord();
        $serverInfo = json_decode($Discord->discordApiCall($Discord->apiGuildBaseUrl . $serverId, false, false,true));
        $channels = json_decode($Discord->discordApiCall($Discord->apiGuildBaseUrl . $serverId . "/channels", false, false,true));
        $roles = json_decode($Discord->discordApiCall($Discord->apiGuildBaseUrl . $serverId . "/roles", false, false,true));

        $serverConfig = json_decode((new Bot)->getConf($serverId));
        if(!$serverConfig) {
            session()->flash("bot_link_failed", true);
            return redirect()->to(route("servers"));
        }

        $langs = json_decode((new Bot)->getConf($serverId));

        return view('dashboard.server_general', compact("id", "serverInfo", "channels", "roles", "serverConfig"));
    }

    public function editServerModeration ($id) {
        $server = (new Server())->where('id', $id)->get()->first();

        $Discord = new Discord();
        $serverInfo = json_decode($Discord->discordApiCall($Discord->apiGuildBaseUrl . $server->server_id, false, false,true));
        $channels = json_decode($Discord->discordApiCall($Discord->apiGuildBaseUrl . $server->server_id . "/channels", false, false,true));
        $roles = json_decode($Discord->discordApiCall($Discord->apiGuildBaseUrl . $server->server_id . "/roles", false, false,true));

        return view('dashboard.server_moderation', compact("serverInfo", "channels", "roles"));
    }

    private function generate2FARecoverCodes() {
        $codes = [];
        $hashedCodes = [];

        $i = 0;
        while($i < 8) {
            $code = substr(md5(uniqid() . sha1(rand(0,424242) . md5(uniqid()))), 0, 9);
            $codes[] = $code;

            $hashedCodes[] = Hash::make($code);
            $i++;
        }

        (new codes2fa())->insert([
            'user_id' => Auth::user()->id,
            'recover_codes' => base64_encode(json_encode($hashedCodes))
        ]);

        return $codes;
    }

    public function get2FACode() {
        $twoFA = new TwoFAuth();

        $secret = $twoFA->createSecret(32);
        $qrUrl = $twoFA->getQRCodeUrl('Botanist Website', $secret);

        return response()->json(['secret' => $secret, 'qrurl' => $qrUrl]);
    }

    public function enable2FACode(Request $request) {
        $twoFA = new TwoFAuth();

        $goodToken = $twoFA->verifyCode($request->secret, $request->token, 1);

        if($goodToken) {
            $recoverCodes = $this->generate2FARecoverCodes();
            (new User())->where('id', Auth::user()->id)->update(['secret_2fa' => $request->secret]);
            return response()->json(['state' => 'success', 'recover_codes' => $recoverCodes]);
        } else {
            return response()->json(['state' => 'error']);
        }

    }

    public function disable2FA () {
        if(empty(Auth::user()->secret_2fa)) return redirect()->to(route('dashboard'));

        return view('dashboard.disable2FA');
    }

    public function remove2FA (Request $request) {
        $codes = json_decode(base64_decode((new codes2fa())->where("user_id", "=", Auth::user()->id)->first()->recover_codes, true));

        foreach ($codes as $code) {
            if (Hash::check($request->reset_code_2fa, $code)) {
                (new codes2fa())->where('user_id', '=', Auth::id())->delete();
                (new User)->where('id', '=', Auth::id())->update(['secret_2fa' => null]);

                session()->flash('2FA_reset', true);
                return redirect()->to(route('dashboard'));
            }
        }
        session()->flash('wrong_code');
        return redirect()->back();
    }

    public function reset2FA () {
        if(!session('2fa_infos')) {
            return redirect()->to(route('login'));
        }  else {
            session()->flash('2fa_infos', session('2fa_infos'));
        }

        return view('reset2FA');
    }

    public function overstep2FA (Request $request) {
        if(!session('2fa_infos')) return redirect()->to(route('login'));

        $codes = json_decode(base64_decode((new codes2fa())->where("user_id", "=", session('2fa_infos')['id'])->first()->recover_codes, true));

        foreach ($codes as $k => $code) {
            if (Hash::check($request->overstep_code_2fa, $code)) {
                unset($codes[$k]);
                $updated_codes = base64_encode(json_encode(array_values($codes)));

                (new codes2fa())->where('user_id', '=', session('2fa_infos')['id'])->update(['recover_codes' => $updated_codes]);

                Auth::loginUsingId(session('2fa_infos')['id']);
                return redirect()->to(route('dashboard'));
            }
        }

        session()->flash('2fa_infos', session('2fa_infos'));
        session()->flash('wrong_code', true);
        return redirect()->back();
    }

    public function deleteAccount () {
        $userId = Auth::id();
        (new Server())->where("user_id", "=", $userId)->delete();
        (new codes2fa())->where("user_id", "=", $userId)->delete();
        Auth::logout();
        (new User)->where("id", "=", $userId)->delete();

        return "success";
    }

    public function logout() {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect()->to(route('home'));
    }
}