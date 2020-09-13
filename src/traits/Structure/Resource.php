<?php


namespace Modular\traits\Structure;


use Modular\traits\Structure\Resource\Js;
use Modular\traits\Structure\Resource\Lang;
use Modular\traits\Structure\Resource\View;

trait Resource
{
    use View, Lang, Js;

    /**
     * returns the name of resources folder
     * @return string
     */
    function getResourcesName()
    {
        return 'resources';
    }

    /**
     * returns the full path of resources folder
     * @return string
     */
    function getResourcesPath()
    {
        return $this->getPackagePath() . $this->fileSeparator() . $this->getResourcesName();
    }

    /**
     * create resources folder
     */
    function initResourcesFolder()
    {
        $this->createFolders($this->getResourcesPath(), $this->getResourcesName());
        $this->createSubFolders($this->resourceFolders());
    }

    /**
     * app sub folders
     *
     * @return array
     */
    private function resourceFolders()
    {
        return ['Js', 'Lang', 'View'];
    }
}