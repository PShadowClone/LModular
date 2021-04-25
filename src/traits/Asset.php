<?php


namespace Modular\traits;


trait Asset
{
    /**
     * assets extension
     *
     * @var string
     */
    private $extension = "stub";

    /**
     * get assets file
     *
     * @param $fileName
     * @return false|string
     */
    function getAssetFile($fileName)
    {
        if (\Modular\Stub::checkIfStubDirExistence())
            return file_get_contents(\Modular\Stub::getStubDir() . "$fileName.{$this->getExtension()}");
        return file_get_contents(__DIR__ . "/../../Assets/$fileName.{$this->getExtension()}");
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * return the path of assets folder
     * @return string
     * @author Amr
     */
    public function getAssetsFolderPath()
    {
        return __DIR__ . "/../../Assets";
    }

}