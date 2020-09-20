<?php


namespace Modular\traits;


use Modular\Exception\PackageAlreadyExisted;

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
        $package = $this->getPackageInstance()->find($this->getPackageName(), $this->getPath());
        if ($package && strtolower($this->getPath()) == strtolower($package->getFullPath()))
            throw new PackageAlreadyExisted();
        if ($package)
            $this->setDuplicate(true);
        (new \Modular\Models\Package(['package' => $this->getPackageName(), 'createdAt' => $this->getCreatedAt(), 'fullPath' => $this->getPath()]))
            ->register();
    }
}