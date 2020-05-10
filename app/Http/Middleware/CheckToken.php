<?php


namespace App\Http\Middleware;

use App\Http\Controllers\DiscordController as Discord;
use Illuminate\Support\Facades\Auth;
use Closure;
use App\User;


class CheckToken
{
    public function handle ($request, Closure $next) {
        if(empty(Auth::user()->access_token)) return $next($request);


        $Discord = new Discord();
        $getServers = json_decode($Discord->discordApiCall($Discord->apiBaseUrl, false, Auth::user()->access_token));

        if(isset($getServers->message) && $getServers->message == "401: Unauthorized") {
            $headers = ['Accept: application/json'];

            $curl = curl_init("https://discordapp.com/api/oauth2/token");
            curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

            $params = [
                'grant_type' => 'refresh_token',
                'client_id' => env("BOTANIST_OAUTH_CLIENT_ID"),
                'client_secret' => env("BOTANIST_OAUTH_CLIENT_SECRET"),
                'refresh_token' => Auth::user()->refresh_token,
                'scope' => 'identify guilds'
            ];
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = json_decode(curl_exec($curl));

            (new User)->where('id', '=', Auth::user()->id)->update([
                'access_token' => $response->access_token,
                'refresh_token' => $response->refresh_token
            ]);
            Auth::user()->access_token = $response->access_token;
            Auth::user()->refresh_token = $response->refresh_token;
        }

        return $next($request);
    }
}