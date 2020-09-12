<?php


namespace Modulars\Package\traits;


use Modulars\Package\Models\MasterDir;

trait Package
{
    /**
     * get the path of master folder
     *
     * @return string
     */
    function getMasterFolder()
    {

        return ucwords(isset($this->getConsole()->options()['path']) && $this->console->option('path') ? $this->console->option('path') : "Modules");
    }

    /**
     * get the full path of master folder
     *
     * @return string
     */
    function getBaseFolder()
    {
        return $this->basePath($this->getMasterFolder());
    }

    /**
     *  create the master folders
     */
    function initMasterFolder()
    {
        return $this->createFolders($this->getBaseFolder(), $this->getMasterFolder());
    }

    /**
     * @return string
     */
    function getPluralPackageName()
    {
        return strtolower(str_plural($this->getPackageName()));
    }

    /**
     * remove package's directory
     *
     * @param $packageName
     * @return bool
     */
    public function removePackage($packageName)
    {
        return shell_exec("rm -rf " . $packageName);
    }

}