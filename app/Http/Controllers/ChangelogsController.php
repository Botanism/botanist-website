<?php


namespace App\Http\Controllers;

use \App\Http\Controllers\LangController as Lang;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml as Yaml;
use Parsedown;

class ChangelogsController
{
    private $defaultPage = "introduction";

    public function main () {
        $Parsedown = new Parsedown();
        $Parsedown->setSafeMode(false);

        $changelogsBaseUrl = storage_path()."/app/changelogs/" . (new Lang)->userLang() . "/";

        $changelogs = [
            'bot' => [],
            'website' => [],
            'linker' => []
        ];

        $applicationGH = ['bot' => 'Botanist', 'website' => 'botanist-website', 'linker' => 'linker'];


        foreach (['bot', 'website', 'linker'] as $app) {
            foreach (scandir($changelogsBaseUrl . $app) as $file) {
                if ($file == "." || $file == "..") continue;
                $fileName = explode('.', $file);
                unset($fileName[sizeof($fileName) - 1]);
                $fileName = implode('.', $fileName);

                if (!preg_match('#^[0-9]([.][0-9])?[_][0-9]{4}[-][0-1]?[0-9][-][0-3]?[0-9]$#', $fileName)) continue;

                $content = file_get_contents($changelogsBaseUrl . $app . "/" . $file);
                $content = preg_replace('/[^\\\][#]([0-9]+)/', ' <a href="https://github.com/Botanism/'.$applicationGH['bot'].'/issues/${1}" target="_blank" rel="nofollow">#${1}</a>', $content); // replacing #X by link to corresponding issue
                $content = $Parsedown->text($content);

                $fileInfo = explode('_', $fileName);
                $changelogs[$app][] = [
                    "version" => $fileInfo[0],
                    "date" => $fileInfo[1],
                    "content" => base64_encode($content)
                ];
            }

            usort($changelogs[$app], function($a, $b) {
               return $b['version'] <=>  $a['version']; // order by version DESC
            });
        }

        return view('changelogs', compact('changelogs'));
    }
}