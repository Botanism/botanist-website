<?php


namespace App\Http\Controllers;

use \App\Http\Controllers\LangController as Lang;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml as Yaml;

class DocController
{
    private $defaultPage = "introduction";

    public function main ($mainDir = null, $subDir = null, $subSubDir = null) {
        $dirs = strtolower((($mainDir)? $mainDir : '') . (($subDir)? '/' . $subDir : '') . (($subSubDir)? '/' . $subSubDir : ''));
        $dirs = (!$mainDir)? $this->defaultPage : $dirs;

        $file = storage_path()."/app/doc/" . (new Lang)->userLang() . "/" . $dirs;

        if (file_exists($file)) {
            $file .= "/_main_.md";
        } elseif (file_exists($file.'.md')) {
            $file .= ".md";
        } else {
            return view('doc', ['Doc' => $this, 'state' => 404, 'dirs' => explode("/", $dirs), 'nav' => $this->getNavTree()]);

        }

        return view('doc', ['Doc' => $this, 'state' => 200, 'file' => $file, 'dirs' => explode("/", $dirs), 'nav' => $this->getNavTree()]);
    }

    private function priorityOrder ($a, $b) {
        return ($a["priority"] <= $b['priority'])? -1 : 1;
    }

    private function scan_dir($url) {
        $elems = scandir($url);
        unset($elems[0], $elems[1]);
        $dirs = [];

        foreach ($elems as $key => $elem) {
            if(is_dir($url . $elem)) {
                $filename = $url . $elem . "/_main_.md";
                $dirs[$elem]["children"] = $this->scan_dir($url.$elem.'/');
            } else {
                if($elem == "_main_.md") continue;

                $filename = $url . $elem;
                $elem =  substr($elem, 0, -3);
            }

            $f = file_get_contents($filename);

            if(Str::contains($f, '[----]')) {
                $pageInfo = Yaml::parse(explode('[----]', $f)[0]);
                if(isset($pageInfo['hidden']) && $pageInfo['hidden']) {
                    unset($dirs[$elem]);
                    continue;
                }

                $title = $pageInfo['title'] ?? ucwords(preg_replace('#_#', ' ', $elem));
                $dirs[$elem]["priority"] = $pageInfo['priority'] ?? 99;
            } else {
                $title = ucwords(preg_replace('#_#', ' ', $elem));
                $dirs[$elem]["priority"] = 99;
            }

            $dirs[$elem]["title"] = $title;
        }

        uasort($dirs, [$this, "priorityOrder"]);

        return $dirs;
    }

    public function getNavTree () {
        $location = storage_path()."/app/doc/" . (new Lang)->userLang() . "/";
        $navTree = [];

        $rootDirs = $this->scan_dir($location);

        return $rootDirs;
    }
}