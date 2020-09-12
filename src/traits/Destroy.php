<?php


namespace Modulars\Package\traits;


use Modulars\Package\Exception\PackageNotFound;

trait Destroy
{
    /**
     * get package model instance
     * @return \Modulars\Package\Models\Package
     */
    function getPackageInstance()
    {
        return new \Modulars\Package\Models\Package();
    }

    /**
     * check package existence
     *
     * @return bool
     */
    function checkPackageExistence()
    {
        $packages = $this->getPackageInstance()->all();
        return in_array($this->getPackageName(), $packages) ? $this->getPackageInstance()->readFile()[$this->getPackageName()] : null;
    }

    /**
     * destroy package
     *
     * @throws PackageNotFound
     */
    function destroy()
    {
        $package = $this->checkPackageExistence();
        if (!$package)
            throw new PackageNotFound('Sorry: package not found');
        $this->removeFrameworkServiceProvider();
        $this->removeFrameworkComposerFile();
        $this->removePackage($this->basePath($package->getFullPath()));
        $this->printConsole("< {$this->getPackageName()} > deleted successfully");
    }
}