<?php


namespace Modular\Models;


use Illuminate\Support\Facades\File;
use Modular\traits\Base;
use Modular\traits\Package\Config;

class Package
{
    use Base, Config;
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
     * storage dir.
     */
    const STORAGE_DIR = __DIR__ . '/../../storage';
    /**
     * the path of storage
     */
    const STORAGE_PATH = __DIR__ . '/../../storage/packages.json';


    function getStorageDir()
    {
        $dir = storage_path('LModular');
        $fileExistence = File::isDirectory($dir);
        if (!$fileExistence)
            File::makeDirectory($dir);
        return $dir;
    }


    function getStoragePath()
    {
        $path = $this->getStorageDir() . $this->fileSeparator() . 'packages.json';
        return $path;
    }

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
        $this->openStorageFolder();
        $fileExistence = $this->exists(self::getStoragePath());
        if (!$fileExistence)
            return [];
        return json_decode(file_get_contents(self::getStoragePath()), true);
    }

    /**
     * register the generated package
     */
    function register()
    {
        $content = $this->readFile();
        $content[$this->getPackage()] = [
            'package' => $this->getPackage(),
            'fullPath' => $this->getFullPath(),
            'createdAt' => $this->getCreatedAt()
        ];

        file_put_contents(self::getStoragePath(), json_encode($content, JSON_PRETTY_PRINT));
    }

    /**
     * refresh the configuration of packages
     * by re-registering them in packages.json
     */
    function refresh()
    {
        file_put_contents(self::getStoragePath(), json_encode([], JSON_PRETTY_PRINT));
        $this->packages()->each(function ($package) {
            $package->register();
        });
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
        try {
            $this->fill($result[$package]);
            return $this;
        } catch (\Exception $exception) {
            return null;
        }

    }

    /**
     * @param $path
     * @return bool
     */
    function openStorageFolder()
    {
        $result = $this->exists(self::getStorageDir());
        if (!$result)
            return $this->mkdir(self::getStorageDir());
    }
}