<?php


namespace Modulars\Package\traits\Structure\Resource;


trait Js
{
    /**
     * returns the name of js folder
     * @return string
     */
    function getJsName()
    {
        return 'js';
    }

    /**
     * returns the full path of js folder
     * @return string
     */
    function getJsPath()
    {
        return $this->getResourcesPath() . $this->fileSeparator() . $this->getJsName();
    }

    /**
     * create js folder
     */
    function initJsFolder()
    {
        $this->createFolders($this->getJsPath(), $this->getJsName());
    }
}