<?php


namespace Modular\traits;


use Illuminate\Support\Str;
use Modular\Console\MasterConsole;
use Modular\Models\MasterDir;

trait Base
{
    /**
     * console instance
     *
     * @var
     */
    public $console;

    /**
     * flag indicates if there is name duplication
     *
     * @var
     */
    public $duplicate = false;


    /**
     * @param mixed $duplicate
     */
    public function setDuplicate($duplicate): void
    {
        $this->duplicate = $duplicate;
    }

    /**
     * @param mixed $duplicate
     */
    public function isDuplicated(): bool
    {
        return $this->duplicate;
    }


    /**
     * create directories
     *
     * @param $path
     * @param int $mode
     * @param bool $recursive
     * @return bool
     */
    function mkdir($path, $mode = 0777, $recursive = true)
    {
        return mkdir($path, $mode, $recursive);
    }

    /**
     * check file existence
     *
     * @param $path
     * @return bool
     */
    function exists($path)
    {
        return file_exists($path);
    }

    /**
     * @return mixed
     */
    public function getConsole()
    {
        return $this->console;
    }

    /**
     * print the message on the console
     *
     * @param $msg
     * @param string $type
     */
    function printConsole($msg, $type = 'info')
    {
        $this->getConsole()->{$type}($msg);
    }

    /**
     * returns the full path of the given path
     *
     * @param $path
     * @return string
     */
    function basePath($path)
    {
        return base_path($path);
    }

    /**
     * returns php directory separator
     *
     * @return string
     */
    function fileSeparator()
    {
        return DIRECTORY_SEPARATOR;
    }

    /**
     * create folders
     *
     * @param $path
     * @param $name
     * @param null $msg
     */
    function createFolders($path, $name, $msg = null)
    {
        if ($this->exists($path)) {
            $this->printConsole("\033[1;33m < {$name} > already existed \033[0m", "line");
            return;
        }
        $this->mkdir($path);
        $this->printConsole($msg ?? "< {$name} > created successfully");
    }

    /**
     * create folder's sub folders
     *
     * @param $folders
     */
    function createSubFolders($folders)
    {
        array_map(function ($folder) {
            $functionName = "init{$folder}Folder";
            $this->$functionName();
        }, $folders);
    }

    /**
     *
     * replace the library's expression with the new package names
     *
     * @param $content
     * @param $oldValue
     * @param $newValue
     * @return mixed
     */
    public function replace($content, $oldValue, $newValue)
    {
        return str_replace($oldValue, $newValue, $content);
    }

    /**
     *  remove all special chars
     *
     * @param $name
     * @return string|string[]|null
     */
    function sanitize($name)
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $name);
    }

    /**
     * plural string
     *
     * @param $value
     * @return string
     */
    function str_plural($value)
    {
        return Str::plural($value);
    }

    /**
     * returns package's parent
     * @return mixed
     */
    function getParent()
    {
        $paths = explode('/', $this->getPath());
        return $paths[sizeof($paths) - 2];
    }

    /**
     * package name with its parent
     * @return string
     */
    function packageNameWithParent()
    {
        $parent = $this->getParent();
        return ucwords($parent) . $this->getPackageName();
    }

    /**
     * get the parent dir of package
     */
    function getParentDir()
    {
        $parent = $this->getParent();
        if (Str::lower($parent) != 'modules')
            return ucwords($parent) . '\\';
        return '';
    }
}