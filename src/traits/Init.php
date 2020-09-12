<?php


namespace Modulars\Package\traits;


trait Init
{

    /**
     * Base constructor.
     * @param $console
     */
    public function __construct($console, $path = null)
    {
        $this->console = $console;
        $this->setPackagePath($path ? $this->basePath($path) : $this->getBaseFolder() . $this->fileSeparator() . $this->getPackageName());
    }


    /**
     * build module
     * @note: start point
     */
    public
    function init()
    {
        $this->register();
        $this->initMasterFolder();
        $this->initPackageFolder();
        $this->generateComposer();  // update the global project's composer
    }
}