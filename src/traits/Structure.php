<?php


namespace Modulars\Package\traits;


use Modulars\Package\traits\Structure\App;
use Modulars\Package\traits\Structure\Config;
use Modulars\Package\traits\Structure\Database;
use Modulars\Package\traits\Structure\Resource;
use Modulars\Package\traits\Structure\Route;

trait Structure
{
    use App, Resource, Route, Database, Config;
    /**
     * @var
     */
    private $packagePath;

    /**
     * set package's path
     * @param $path
     */
    function setPackagePath($path)
    {
        $this->packagePath = $path;
    }

    /**
     * get the name of package
     *
     * @param $plural , this flag indicates if you want plural name or not
     * @return mixed
     */
    function getPackageName($plural = false)
    {
        $name = ucfirst($this->sanitize($this->getConsole()->argument('name')));
        if ($plural)
            return strtolower(str_plural($name));
        return $name;
    }

    /**
     * package's full path
     *
     * @return string
     */
    function getPackagePath()
    {
        return $this->packagePath;
    }

    /**
     * create the package
     */
    function initPackageFolder()
    {
        $this->createFolders($this->getPackagePath(), $this->getPackageName());
        $this->initAppFolder();
        $this->initResourcesFolder();
        $this->initRoutesFolder();
        $this->initDatabasesFolder();
        $this->initConfigFolder();

    }
}