<?php


namespace Modular;


use Modular\traits\Asset;
use Modular\traits\Base;

class Stub
{
    use Base, Asset;

    /**
     * return the publish path of the stub files
     * @return string
     * @author Amr
     */
    static function getStubDir()
    {
        return self::basePath('packages/l-modular/assets/');
    }

    /**
     * check if the published dir. existed
     * @return bool
     * @author Amr
     */
    static function checkIfStubDirExistence()
    {
        return file_exists(static::getStubDir());
    }

    /**
     * Base constructor.
     * @param $console
     */
    public function __construct($console, $path = null)
    {
        $this->console = $console;
    }

    /**
     * copy directory from source to destination
     * @param $src
     * @param $dst
     * @author Amr
     */
    function recurse_copy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    recurse_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    /**
     * publish the stubs of modular
     * @author Amr
     */
    public function publish()
    {
        $result = file_exists(static::getStubDir());
        if ($result) {
            $this->printConsole("Package's stubs already published ...", 'warn');
            return;
        }
        $this->mkdir(static::getStubDir());
        $this->recurse_copy($this->getAssetsFolderPath(), static::getStubDir());
        $this->printConsole('Package\'s stubs published successfully');
    }

}