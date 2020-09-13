<?php


namespace Modular\Models;


use Modular\Exception\MasterDirException;

class MasterDir
{
    private $packageName;

    public function __construct($packageName)
    {
        $this->packageName = $this->getPackageName($packageName);
    }

    /**
     * something wrong flag
     */
    const SOMETHING_WENT_WRONG = 0;
    /**
     * the package removed successfully
     */
    const REMOVED_SUCCESSFULLY = 1;
    /**
     * this is the master dir. contains the system's packages
     */
    const MASTER_DIR = 'Core';
    /**
     * the path of package
     */
    const PACKAGE_PATH = __DIR__;
    /**
     * file or dir is already existed
     */
    const EXISTED_DIR = 1;
    /**
     * file or dir is not existed its a new one
     */
    const NOT_EXISTED_DIR = 2;
    /**
     * the parent folder for all copied files
     */
    const ASSETS_DIR = 'Assets';
    /**
     * library's name
     */
    const LIBRARY_NAME = 'Modular';
    /**
     * table's primary key's name
     */
    const TABLE_PRIMARY_KEY = 'id';
    /**
     * table's primary key's name
     */
    const DEFAULT_LANG_FILE_NAME = 'lang';

    /**
     * controls the format of package's name
     *
     * @param $packageName
     * @return string
     */
    public function getPackageName($packageName = null)
    {
        if ($packageName)
            return ucfirst($packageName);
        return ucfirst($this->packageName);
    }

    protected function getPackagePath($file = null)
    {
        if ($file)
            return base_path(self::MASTER_DIR . '/' . $file);
        return MasterDir::PACKAGE_PATH;
    }

    /**
     * get the path of master dir.
     *
     * @return string
     */
    protected function getMasterDir()
    {
        return base_path(MasterDir::MASTER_DIR);
    }


    /**
     *
     * check the existence of the given file or dir
     *
     * @param $dirName
     * @return bool
     */
    protected function checkFileExistence($dirName)
    {
        return file_exists($dirName);
    }


    /**
     * get the full path of the given file or dir
     *
     * @param $dirName
     * @return string
     */
    protected function getDir($dirName, $packageFiles = false)
    {
        if (!$packageFiles)
            return base_path($dirName);
        return MasterDir::PACKAGE_PATH . '/../' . MasterDir::ASSETS_DIR . '/' . $dirName;
    }

    /**
     *
     * create the file or dir. is it's not existence
     *
     * @param $dirName
     * @return bool
     * @throws MasterDirException
     */
    public function createDirs($dirName, $master = false)
    {
        if ($master)
            $fullFilePath = $this->getDir($dirName);
        else
            $fullFilePath = $this->getDir(MasterDir::MASTER_DIR . '/' . $dirName);
        try {
            if ($this->checkFileExistence($fullFilePath))
                return MasterDir::EXISTED_DIR;
            mkdir($fullFilePath);
            return MasterDir::NOT_EXISTED_DIR;
        } catch (\Exception $exception) {
            throw new MasterDirException("Something went wrong while creating the directory");
        }
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
     * get the composer path for composer's name and psr-4
     *
     * @return string
     */
    public function getPSRNamespace()
    {
        return MasterDir::MASTER_DIR . '/' . $this->getPackageName();
    }

    /**
     * get package's files namespace
     *
     * @return string
     */
    public function getNameSpace()
    {
        return MasterDir::MASTER_DIR . '\\' . $this->getPackageName();
    }

    /**
     * get library's name
     *
     * @return string
     */
    protected function getLibraryName()
    {
        return self::LIBRARY_NAME;
    }

    /**
     * get the models' database table
     *
     * @return string
     */
    protected function getTableName()
    {
        return strtolower($this->getPackageName()) . 's';
    }

    /**
     * get table primary key
     *
     * @return string
     */
    protected function getPrimaryKey()
    {
        return self::TABLE_PRIMARY_KEY;
    }

    /**
     * get migration name
     *
     * @param bool $purpose
     * @return string
     */
    protected function getMigrationName($purpose = true)
    {
        $functionName = 'create';
        if (!$purpose)
            $functionName = 'update';
        return date('Y_m_d') . '_00000_' . $functionName . '_' . strtolower($this->getPackageName()) . 's_' . 'table';
    }

    /**
     * get controller name
     *
     * @return string
     */
    protected function getControllerName()
    {
        return $this->getPackageName() . "Controller";
    }

    /**
     * indicate where package's service provider should be injected
     *
     * @return string
     */
    protected function getProviderStartingExpression()
    {
        return "'providers' => [";
    }

    /**
     * get the configuration name of the package
     * @return string
     */
    protected function getConfigurationName()
    {
        return $this->getPackageName() . 'Config';
    }

    /**
     * remove package's directory
     *
     * @param $packageName
     * @return bool
     */
    public static function removePackage($packageName)
    {
        return shell_exec("rm -rf " . $packageName);
    }


}