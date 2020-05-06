<?php


namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DiscordController
{

    private $OAuth2ClientId, $OAuth2ClientSecret, $botPrivateToken;

    private $authUrl = "https://discordapp.com/api/oauth2/authorize";
    private $tokenUrl = "https://discordapp.com/api/oauth2/token";

    public $apiBaseUrl = "https://discordapp.com/api/users/@me";
    public $apiGuildBaseUrl = "https://discordapp.com/api/guilds/";

    function __construct() {
        $this->OAuth2ClientId = env("BOTANIST_OAUTH_CLIENT_ID"); //TODO : CHANGE FOR THE GIT
        $this->OAuth2ClientSecret = env("BOTANIST_OAUTH_CLIENT_SECRET"); //TODO : HIDE IT !!!!!!!!!!!!!
        $this->botPrivateToken = env("BOTANIST_PRIVATE_TOKEN"); //TODO : HIDE ME !!!!!!!!!!!!!!!!
    }


//    public function getDiscordCode() {
//        $params = [
//            'client_id' => $this->OAuth2ClientId,
//            'redirect_uri' => 'http://localhost:8000/discord_login',
//            'response_type' => 'code',
//            'scope' => 'identify guilds'
//        ];
//
//        $return = file_get_contents($this->authUrl . '?' . http_build_query($params));
//        return $return;
//    }


    public function discordApiCall ($url, $code=false, $token=false, $isBot=false) {
        $headers = ['Accept: application/json'];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

        if($code) {
            $params = [
                'grant_type' => 'authorization_code',
                'client_id' => $this->OAuth2ClientId,
                'client_secret' => $this->OAuth2ClientSecret,
                'redirect_uri' => 'http://localhost:8000/discord_login',
                'code' => $code
            ];
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        }

        if ($token) $headers[] = 'Authorization: Bearer ' . $token;
        if ($isBot) $headers[] = 'Authorization: Bot ' . $this->botPrivateToken;

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        return curl_exec($curl);
    }

    public function discordLogin() {
        if (isset($_GET['error']) || empty($_GET['code'])) return redirect()->to(route('login'));

        $code = $_GET['code'];

        $discordGet = json_decode($this->discordApiCall($this->tokenUrl, $code));

        if(property_exists($discordGet, 'error')) {
            return redirect()->to(route('login'));
        }

        $token = $discordGet->access_token;

        $user = json_decode($this->discordApiCall($this->apiBaseUrl, false, $token));

        $dbUser = (new User)->where('discord_id', '=', $user->id);

        if ($dbUser->exists()) {
            if(Auth::check()) {
                session()->flash('discord_account_already_linked', true);
                return redirect()->to(route('dashboard'));
            }

            $dbUser->update(['access_token' => $token]);
            if (empty($dbUser->first()->secret_2fa)) {
                Auth::loginUsingId($dbUser->first()->id);
                return redirect()->to(route('dashboard'));
            } else {
                session()->flash('2fa_infos', ['id' => $dbUser->first()->id, 'secret' => $dbUser->first()->secret_2fa]);
                return redirect()->to(route('check_2fa'));
            }
        } else {
            if(Auth::check()) {
                (new User())->where('id', '=', Auth::id())->update([
                    'discord_id' => $user->id,
                    'access_token' => $token
                ]);
                session()->flash('discord_account_successfully_linked', true);
                return redirect()->to(route('dashboard'));
            } else {
                $accountId = (new User)::insertGetId([
                    'pseudo' => null,
                    'discord_id' => $user->id,
                    'email' => null,
                    'password' => null,
                    'access_token' => $token,
                    'created_at' => Carbon::now(),
                    'updated_at' => null
                ]);
                Auth::loginUsingId($accountId);
                return redirect()->to(route('dashboard'));
            }
        }
    }

    public function getDiscordInfos() {
        if(!empty(Auth::user()->discord_id)) {
            return json_decode($this->discordApiCall($this->apiBaseUrl, false, Auth::user()->access_token));
        } else {
            return null;
        }
    }
}