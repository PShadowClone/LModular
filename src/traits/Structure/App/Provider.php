<?php


namespace Modular\traits\Structure\App;


trait Provider
{
    /**
     * returns the name of providers folder
     * @return string
     */
    function getProviderName()
    {
        return 'Providers';
    }

    /**
     * returns the full path of providers folder
     * @return string
     */
    function getProviderPath()
    {
        return $this->getAppPath() . $this->fileSeparator() . $this->getProviderName();
    }

    /**
     * create providers folder
     */
    function initProviderFolder()
    {
        $this->createFolders($this->getProviderPath(), $this->getProviderName());
        $this->generateProvider();
        $this->getFrameworkServiceProvider();
    }

    /**
     * provider's namespace
     *
     * @return string
     */
    function getProviderNamespace()
    {
        return $this->getAppNamespace() . '\Providers';
    }


    /**
     * generate the provider of package
     */
    function generateProvider()
    {
        $content = $this->getAssetFile('ServiceProvider');
        $packageFullPath = $this->getMasterFolder() . $this->fileSeparator() . $this->getPackageName();
        $content = $this->replace($content,
            ['{provider_namespace}', '{package}', "{package_path}", "{controller_namespace}", "{PackageWithParent}"],
            [$this->getProviderNamespace(), $this->getPackageName(), $packageFullPath, $this->getControllerNamespace(), $this->packageNameWithParent()]);
        file_put_contents($this->getProviderPath() . $this->fileSeparator() . $this->getPackageName() . 'ServiceProvider.php', $content);
        $this->printConsole($msg ?? "< Provider > generated successfully");
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
     * add package's service provider into app config file
     */
    private function getFrameworkServiceProvider()
    {
        $result = file_get_contents($this->basePath('config/app.php'));
        $newServiceProvider = $this->getProviderNamespace() . '\\' . $this->getPackageName() . 'ServiceProvider';
        $newContent = $this->replace($result, $this->getProviderStartingExpression(), $this->getProviderStartingExpression() . '
        ' . $newServiceProvider . '::class,');
        file_put_contents($this->basePath('config/app.php'), $newContent);
    }

    /**
     * remove the package's service provider
     */
    function removeFrameworkServiceProvider()
    {
        $result = file_get_contents($this->basePath('config/app.php'));
        $newServiceProvider = ' ' . $this->getProviderNamespace() . '\\' . $this->getPackageName() . 'ServiceProvider::class,';
        $newContent = $this->replace($result, $newServiceProvider, '');
        file_put_contents($this->basePath('config/app.php'), $newContent);
    }
}