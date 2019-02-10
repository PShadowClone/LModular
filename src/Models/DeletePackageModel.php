<?php


namespace Modulars\Package\Models;

use Modulars\Package\Console\MasterConsole;


class DeletePackageModel extends MasterDir
{
    private $packageName;
    private $command;

    public function __construct($packageName, $command)
    {
        parent::__construct($packageName);
        $this->packageName;
        $this->command = $command;
    }

    /**
     * delete package
     *
     * @return int
     */
    public function delete()
    {
        $checkResult = $this->checkExistence();
        if (!$checkResult)
            return self::NOT_EXISTED_DIR;
        $removeServiceProviderDep = $this->removeServiceProvider();
        $removeComposerDep = $this->removeComposerDependency();
        if (!$removeServiceProviderDep)
            $this->command->info("Could not remove package's service provider dependency");
        if (!$removeComposerDep)
            $this->command->info("Could not remove composer's dependency");
        if ($removeComposerDep && $removeServiceProviderDep) {
            shell_exec('composer dump-autoload');
            $this->command->info($this->getPackageName($this->packageName) . "'s dependencies have been removed successfully'");
        }
        try {
            $fullPath = $this->getPackagePath($this->getPackageName($this->packageName));;
            $result = MasterDir::removePackage($fullPath);
            if (!is_null($result)) {
                $this->command->info('Could not remove dir');
                return self::SOMETHING_WENT_WRONG;
            }
        } catch (\Exception $exception) {
            return self::SOMETHING_WENT_WRONG;
        }
        return self::REMOVED_SUCCESSFULLY;
    }

    /**
     * check if the package is existed or not
     * @return bool
     */
    private function checkExistence()
    {
        $packageName = $this->getPackageName($this->packageName);
        $fullPath = $this->getPackagePath($packageName);
        return $this->checkFileExistence($fullPath);
    }

    /**
     * remove package's service provider from app.php file
     *
     * @return bool
     */
    private function removeServiceProvider()
    {
        try {
            $result = file_get_contents($this->getDir('config/app.php'));
            $newServiceProvider = $this->getNameSpace() . '\\Providers' . '\\' . $this->getPackageName($this->packageName) . 'ServiceProvider';
            $newContent = $this->replace($result, $newServiceProvider . '::class,', '');
            file_put_contents($this->getDir('config/app.php'), $newContent);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * remove composer dependency
     *
     * @return bool
     */
    private function removeComposerDependency()
    {
        try {
            $superComposer = file_get_contents($this->getDir('composer.json'));
            $content = json_decode($superComposer, true);
            unset($content['autoload-dev']['psr-4'][self::MASTER_DIR . '\\' . $this->getPackageName($this->packageName) . '\\']);
            $content = json_encode($content, JSON_PRETTY_PRINT);
            $content = $this->replace($content, '\/', '/');
            file_put_contents($this->getDir('composer.json'), $content);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}