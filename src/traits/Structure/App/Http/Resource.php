<?php


namespace Modular\traits\Structure\App\Http;


trait Resource
{
    /**
     * returns the name of Resources folder
     * @return string
     */
    function getResourceName()
    {
        return 'Resources';
    }

    /**
     * returns the full path of http folder
     * @return string
     */
    function getResourcePath()
    {
        return $this->getHttpPath() . $this->fileSeparator() . $this->getResourceName();
    }

    /**
     * create http folder
     */
    function initResourceFolder()
    {
        $this->createFolders($this->getResourcePath(), $this->getResourceName());
        $this->generateResource();
    }

    /**
     * Resource's namespace
     *
     * @return string
     */
    function getResourceNamespace()
    {
        return $this->getPackageName() . '\App\Http';
    }

    /**
     * get the generated Resource
     * @return string
     */
    function getGeneratedResourceName()
    {
        return isset($this->getConsole()->arguments()['resource']) ? ucwords($this->sanitize($this->getConsole()->argument('resource'))) : 'Resource';
    }

    /**
     * generate the Resource of package
     */
    function generateResource()
    {
        $content = $this->getAssetFile('Resource');
        $content = $this->replace($content, ['{resource_namespace}', '{package}', '{resource}'],
            [$this->getResourceNamespace(), $this->getPackageName(), $this->getGeneratedResourceName()]);
        file_put_contents($this->getResourcePath() . $this->fileSeparator() . $this->getGeneratedResourceName() . '.php', $content);
        $this->printConsole($msg ?? "< Resource > generated successfully");
    }
}