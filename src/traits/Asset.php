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

}