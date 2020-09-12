<?php


namespace Modulars\Package\traits\Structure\App;


use Modulars\Package\traits\Structure\App\Http\Controller;
use Modulars\Package\traits\Structure\App\Http\Middleware;

trait Http
{
    use Controller, Middleware;

    /**
     * returns the name of http folder
     * @return string
     */
    function getHttpName()
    {
        return 'Http';
    }

    /**
     * returns the full path of http folder
     * @return string
     */
    function getHttpPath()
    {
        return $this->getAppPath() . $this->fileSeparator() . $this->getHttpName();
    }

    /**
     * create http folder
     */
    function initHttpFolder()
    {
        $this->createFolders($this->getHttpPath(), $this->getHttpName());
        $this->createSubFolders($this->httpFolders());
    }

    /**
     * http sub folders
     *
     * @return array
     */
    private function httpFolders()
    {
        return ['Controller', 'Middleware'];
    }
}