<?php

namespace Modular\traits\Structure;

trait PublicFolder
{
    /**
     * returns the name of config folder
     * @return string
     */
    function getPublicName()
    {
        return 'public';
    }

    /**
     * returns the full path of config folder
     * @return string
     */
    function getPublicPath()
    {
        return $this->getPackagePath() . $this->fileSeparator() . $this->getPublicName();
    }

    /**
     * create config folder
     */
    function initPublicFolder()
    {
        $this->createFolders($this->getPublicPath(), $this->getPublicName());
    }

}