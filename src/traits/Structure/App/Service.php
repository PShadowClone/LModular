<?php


namespace Modular\traits\Structure\App;


trait Service
{
    /**
     * returns the name of services folder
     * @return string
     */
    function getServiceName()
    {
        return 'Services';
    }

    /**
     * returns the full path of services folder
     * @return string
     */
    function getServicePath()
    {
        return $this->getAppPath() . $this->fileSeparator() . $this->getServiceName();
    }

    /**
     * create services folder
     */
    function initServiceFolder()
    {
        $this->createFolders($this->getServicePath(), $this->getServiceName());
        $this->generateService();
    }

    /**
     * service's namespace
     *
     * @return string
     */
    function getServiceNamespace()
    {
        return $this->getAppNamespace();
    }

    /**
     * get the generated repo
     * @return string
     */
    function getGeneratedServiceName()
    {
        return isset($this->getConsole()->arguments()['class']) ? ucwords($this->sanitize($this->getConsole()->argument('class'))) : 'Service';
    }

    /**
     * generate the service of package
     */
    function generateService()
    {
        $content = $this->getAssetFile('Service');
        $content = $this->replace($content,
            ['{service_namespace}', '{service}'],
            [$this->getServiceNamespace(), $this->getGeneratedServiceName()]);
        file_put_contents($this->getServicePath() . $this->fileSeparator() . $this->getGeneratedServiceName() . '.php', $content);
        $this->printConsole($msg ?? "< Service > generated successfully");
    }
}