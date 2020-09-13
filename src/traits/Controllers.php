<?php


namespace Modular\traits;


trait Controllers
{
    /**
     * returns the path of Controllers
     *
     * @return string
     */
    function getControllersPath()
    {
        return "{$this->getHttpDir()}Controllers";
    }

    /**
     * create controller dir.
     */
    public function createControllerDir()
    {
//        mkdir($this->getPackagePath($this->getMaterDir()));
        dd($this->getPackagePath($this->getSrcPath()));
        mkdir($this->getPackagePath($this->getSrcPath()));
        mkdir($this->getPackagePath($this->getHttpDir()));
        mkdir($this->getPackagePath($this->getHttpDir()) . '/' . self::getControllersPath());
        $this->printCommand($this->getPackageName() . ' : controllers folder generated successfully');
    }

    public function getControllersNameSpaces()
    {
        return $this->getNameSpace() . '\\' . 'Http\\Controllers';
    }

    /**
     * generate new Controller for the new package
     */
    public function generatePackageController()
    {
        $packageController = $this->getAssetsDir($this->getStubFiles('PackageController'), true);
        $packageControllerContents = file_get_contents($packageController);
        $newControllerContent = $this->replace($packageControllerContents,
            ['{package_controller_name}', '{package_name_space}', "{package_name}"],
            ["Controller", $this->getNameSpace(), $this->getPackageName()]);
        $packageController = $this->getPackagePath($this->getPackageName()) . '/' .
            self::getControllersPath() .
            $this->getFileSeparator() . 'Controller.php';
        file_put_contents($packageController, $newControllerContent);
        $this->printCommand($this->getPackageName() . 'Controller generated successfully');
    }
}