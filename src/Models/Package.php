<?php


namespace Modular\Models;


use Modular\traits\Base;

class Package
{
    use Base;
    /**
     * datetime of creating packages
     *
     * @var
     */
    private $createdAt;
    /**
     * the name of package
     *
     * @var
     */
    private $package;

    /**
     * package's full path
     * @var
     */
    private $fullPath;
    /**
     * the path of storage
     */
    const STORAGE_PATH = __DIR__ . '/../../storage/packages.bak';

    /**
     * Package constructor.
     * @param $attributes
     */
    public function __construct($attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }


    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param mixed $package
     */
    public function setPackage($package): void
    {
        $this->package = $package;
    }

    /**
     * @return mixed
     */
    public function getFullPath()
    {
        return $this->fullPath;
    }

    /**
     * @param mixed $fullPath
     */
    public function setFullPath($fullPath): void
    {
        $this->fullPath = $fullPath;
    }

    /**
     * fill all attributes according to the given
     * array
     *
     * @param $attributes
     */
    function fill($attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * read the content of packages.bak
     */
    public function readFile()
    {
        $fileExistence = $this->exists(self::STORAGE_PATH);
        if (!$fileExistence)
            return [];
        return unserialize(file_get_contents(self::STORAGE_PATH));
    }

    /**
     * register the generated package
     */
    function register()
    {
        $content = $this->readFile();
        $this->fill([
            'package' => $this->getPackage(),
            'fullPath' => $this->getFullPath(),
            'createdAt' => $this->getCreatedAt()
        ]);
        $content[$this->getPackage()] = $this;
        file_put_contents(self::STORAGE_PATH, serialize($content));
    }

    /**
     * get all generated packages
     *
     * @return array|mixed
     */
    function all()
    {
        return array_keys($this->readFile());
    }

    /**
     * find package according to the give package name
     *
     * @param $package
     * @return mixed
     */
    function find($package)
    {
        $result = $this->readFile();
        return $result[$package];
    }


}