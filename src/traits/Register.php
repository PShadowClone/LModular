<?php


namespace Modular\traits;


trait Register
{
    /**
     * get package base path
     *
     * @return mixed
     */
    function getPath()
    {
        return str_replace(base_path() . $this->fileSeparator(), "", $this->getPackagePath());
    }

    /**
     * get the time of creating package
     */
    function getCreatedAt()
    {
        return date('Y-m-d h:m:s');
    }

    /**
     *
     * register the created package
     */
    function register()
    {
        (new \Modular\Models\Package(['package' => $this->getPackageName(), 'createdAt' => $this->getCreatedAt(), 'fullPath' => $this->getPath()]))
            ->register();
    }
}