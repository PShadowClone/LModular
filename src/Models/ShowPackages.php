<?php

namespace Modular\Package\Models;

use Modular\Package\Console\MasterConsole;

class ShowPackages extends MasterDir
{

    /**
     * get all generated packages
     *
     * @return array|int|is_dir
     */
    public function getListedPackages()
    {
        $masterDir = $this->getMasterDir();
        $result = $this->checkFileExistence($masterDir);
        if (!$result)
            return -1;
        $dirs = array_filter(glob($masterDir . '/*'), 'is_dir');
        $dirs = $this->removePath($dirs, $masterDir);
        return $dirs;
    }

    /**
     * remove the full path of folders and return just package name
     *
     * @param $dirs
     * @param $masterDir
     * @return array
     */
    private function removePath($dirs, $masterDir)
    {
        return array_map(function ($item) use ($masterDir) {
            return str_replace($masterDir . '/', '', $item);
        }, $dirs);
    }

}