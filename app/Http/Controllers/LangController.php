<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class LangController
{
    private $allowedLanguages = ["fr", "en"];
    private $defaultLang = "fr";
    private $defaultFile = "main";

    /**
     * @return string
     */
    public function getDefaultLang() {
        return $this->defaultLang;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllowedLanguages() {
        return response()->json($this->allowedLanguages);
    }

    /**
     * @return string
     */
    public function userLang() {
        $cookieLang = Cookie::get('lang');
        if(!empty($cookieLang)) {
            $lang = $cookieLang;
        } else {
            $lang = $this->getDefaultLang();
        }
        return $lang;
    }

    /**
     * @param string $key
     * @param $file
     * @param $forcedLang
     * @return string
     */
    public function get($key, $file = false, $forcedLang = false) {
        $lang = ($forcedLang)? $forcedLang : $this->userLang();
        $file = ($file)? $file : $this->defaultFile;

        if(!file_exists(storage_path()."/app/langs/".$lang."/".$file.".json")) {
            if(!file_exists(storage_path()."/app/langs/".$this->defaultLang."/".$file.".json")) {
                return "LANG ERROR: THE FILE DOESN'T EXIST";
            } else {
                $lang = $this->defaultLang;
            }
        }

        $langFile = json_decode(file_get_contents(storage_path()."/app/langs/".$lang."/".$file.".json"), true);
        if(!array_key_exists($key, $langFile)) {
            $langFile = json_decode(file_get_contents(storage_path()."/app/langs/".$this->defaultLang."/".$file.".json"), true);
            if(!array_key_exists($key, $langFile)) {
                return "LANG ERROR: TRANSLATION DOESN'T EXIST";
            }
            return $langFile[$key];
        }
        return $langFile[$key];
    }

    /**
     * @param $lang
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeLang($lang) {
        if(!preg_match('#[a-z]{2}#', $lang)) {
            return response()->json(['state' => 'error', 'message'=> $this->get('lang_bad_format')]);
        }
        if(!in_array($lang, $this->allowedLanguages)) {
            return response()->json(['state' => 'error', 'message'=> $this->get('lang_not_supported')]);
        }

        Cookie::queue('lang', $lang, 60 * 24 * 30 * 365);
        return response()->json(['state' => 'success', 'message'=> $this->get('lang_changed_successfully')]);
    }
}