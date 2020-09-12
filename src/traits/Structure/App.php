<?php


namespace Modulars\Package\traits\Structure;


use Modulars\Package\traits\Structure\App\Exception;
use Modulars\Package\traits\Structure\App\Http;
use Modulars\Package\traits\Structure\App\Model;
use Modulars\Package\traits\Structure\App\Provider;
use Modulars\Package\traits\Structure\App\Repository;

trait App
{
    use Http, Provider, Exception, Model, Repository;

    /**
     * returns the name of app folder
     * @return string
     */
    function getAppName()
    {
        return 'app';
    }

    /**
     * returns the full path of app folder
     * @return string
     */
    function getAppPath()
    {
        return $this->getPackagePath() . $this->fileSeparator() . $this->getAppName();
    }

    /**
     * create app folder
     */
    function initAppFolder()
    {
        $this->createFolders($this->getAppPath(), $this->getAppName());
        $this->createSubFolders($this->appFolders());
    }

    /**
     * app sub folders
     *
     * @return array
     */
    private function appFolders()
    {
        return ['Provider', 'Exception', 'Model', 'Http', 'Repository'];
    }
}