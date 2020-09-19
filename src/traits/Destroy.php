<?php


namespace Modular\traits;


use Modular\Exception\PackageNotFound;

trait Destroy
{
    /**
     * get package model instance
     * @return \Modular\Models\Package
     */
    function getPackageInstance()
    {
        return new \Modular\Models\Package();
    }

    /**
     * find package existence
     *
     * @return bool
     */
    function __findPackage($package)
    {
        return $this->getPackageInstance()->find($package);
    }

    /**
     * destroy package
     *
     * @throws PackageNotFound
     */
    function destroy()
    {
        $package = $this->__findPackage($this->getPackageName());
        if (!$package)
            throw new PackageNotFound('Sorry: package not found');
        $this->removeFrameworkServiceProvider();
        $this->removeFrameworkComposerFile();
        $this->removePackage($this->basePath($package->getFullPath()));
        $this->printConsole("< {$this->getPackageName()} > deleted successfully");
    }
}