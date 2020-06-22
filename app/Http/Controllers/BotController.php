<?php


namespace App\Http\Controllers;


use App\Http\Controllers\DiscordController as Discord;
use App\Http\Controllers\LangController as Lang;

class BotController
{
    private $apiUrl;

    public function __construct() {
        $this->apiUrl = env("BOTANIST_API_URL");
    }

    public function hasBot ($serverId) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/server/'.$serverId);
        $query = curl_exec($ch);
        curl_close($ch);


        if(!$query) return false;

        $response = json_decode($query)->has_bot;


        return $response;
    }

    public function getConf($serverId) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/config/'.$serverId);
        $query = curl_exec($ch);
        curl_close($ch);

        if(!$query) return false;

        return $query;
    }

    public function getLangs() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/langs');
        $query = curl_exec($ch);
        curl_close($ch);

        if(!$query) return false;

        return $query;
    }

    private function checkRoles($serverRoles, $roles, $canBeEmpty=true) {
        $rolesList = [];
        if(sizeof($roles) == 1 && $roles[0] == "") {
            if($canBeEmpty) {
                return [true, []];
            } else {
                return [false, $Lang->get("general_field_required")];
            }
        }
        foreach ($roles as $role) {
            if(!in_array($role, $serverRoles)) {
                return [false, $Lang->get("role_not_on_server")];
            } else {
                $rolesList[] = intval($role);
            }
        }
        return [true, $rolesList];
    }

    private function checkChannels($serverChannels, $channels) {
        $channelsList = [];
        if(sizeof($channels) == 1 && $channels[0] == "") return [];
        foreach ($channels as $channel) {
            if(!in_array($channel, $serverChannels)) {
                return false;
            } else {
                $channelsList[] = intval($channel);
            }
        }
        return $channelsList;
    }

    public function updateConfig($serverId, $newConfFields) {
        $srvConf = json_decode($this->getConf($serverId), true);

        $Lang = new Lang();
        $Discord = new Discord();
        // $serverInfo = json_decode($Discord->discordApiCall($Discord->apiGuildBaseUrl . $serverId, false, false,true));
        $getChannels = json_decode($Discord->discordApiCall($Discord->apiGuildBaseUrl . $serverId . "/channels", false, false,true));
        $getRoles = json_decode($Discord->discordApiCall($Discord->apiGuildBaseUrl . $serverId . "/roles", false, false,true));

        $rolesList = [];
        foreach ($getRoles as $role) {
            $rolesList[] = $role->id;
        }

        $channelsList = [];
        foreach ($getChannels as $channel) {
            $channelsList[] = $channel->id;
        }

        if(isset($newConfFields["role_free"])) {
            $roles = $this->checkRoles($rolesList, $newConfFields["role_free"]);
            if($roles[0] === false) {
                return ["state" => "error", "error" => $roles[1]];
            } else {
                $srvConf["free_roles"] = $roles[1];
            }
        }

        if(isset($newConfFields["role_manager"])) {
            $roles = $this->checkRoles($rolesList, $newConfFields["role_manager"], false);
            if ($roles[0] === false) {
                return ["state" => "error", "error" => $roles[1]];
            } else {
                $srvConf["roles"]["manager"] = $roles[1];
            }
        }

        if(isset($newConfFields["role_admin"])) {
            $roles = $this->checkRoles($rolesList, $newConfFields["role_admin"], false);
            if($roles[0] === false) {
                return ["state" => "error", "error" => $roles[1]];
            } else {
                $srvConf["roles"]["admin"] = $roles[1];
            }
        }

        if(isset($newConfFields["language"])) {
            $langs = explode(" ", json_decode($this->getLangs()));
            if(in_array($newConfFields["language"], $langs)) {
                $srvConf["lang"] = $newConfFields["language"];
            } else {
                return ["state" => "error", "error" => $Lang->get("language_not_available")];
            }
        }

        if(isset($newConfFields["welcome_message"])) {
            $srvConf["messages"]["welcome"] = $newConfFields["welcome_message"];
        }

        if(isset($newConfFields["goodbye_message"])) {
            $srvConf["messages"]["goodbye"] = $newConfFields["goodbye_message"];
        }

        if(isset($newConfFields["channel_todo"])) {
            if ($newConfFields["channel_todo"] == "") {
                $srvConf["todo_channel"] = false;
            } elseif(in_array($newConfFields["channel_todo"], $channelsList)) {
                //// Temporary disabled ////
                // $srvConf["todo_channel"] = intval($newConfFields["channel_todo"]);
            } else {
                return ["state" => "error", "error" => $Lang->get("channel_not_on_server")];
            }
        }

        if(isset($newConfFields["channel_report"])) {
            if ($newConfFields["channel_report"] == "") {
                $srvConf["commode"]["reports_chan"] = false;
            } elseif (in_array($newConfFields["channel_report"], $channelsList)) {
                $srvConf["commode"]["reports_chan"] = intval($newConfFields["channel_report"]);
            } else {
                return ["state" => "error", "error" => $Lang->get("channel_not_on_server")];
            }
        }

        if(isset($newConfFields["channel_advertisement"])) {
            if ($newConfFields["channel_advertisement"] == "") {
                $srvConf["advertisement"] = false;
            } elseif (in_array($newConfFields["channel_advertisement"], $channelsList)) {
                $srvConf["advertisement"] = intval($newConfFields["channel_advertisement"]);
            } else {
                return ["state" => "error", "error" => $Lang->get("channel_not_on_server")];
            }
        }

        if(isset($newConfFields["channel_poll"])) {
            $channels = $this->checkChannels($channelsList, $newConfFields["channel_poll"]);
            if($channels === false) {
                return ["state" => "error", "error" => $Lang->get("channel_not_on_server")];
            } else {
                $srvConf["poll_channels"] = $channels;
            }
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(["conf" => json_encode($srvConf)]));
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/update/'.$serverId);
        $query = curl_exec($ch);
        curl_close($ch);

        if($query === false) return ["state" => "error", "error" => $Lang->get("bot_link_failed")];

        return ["state" => "success"];
    }
}

