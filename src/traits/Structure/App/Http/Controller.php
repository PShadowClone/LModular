<?php


namespace Modular\traits\Structure\App\Http;


trait Controller
{
    /**
     * returns the name of controllers folder
     * @return string
     */
    function getControllerName()
    {
        return 'Controllers';
    }

    /**
     * returns the full path of http folder
     * @return string
     */
    function getControllerPath()
    {
        return $this->getHttpPath() . $this->fileSeparator() . $this->getControllerName();
    }

    /**
     * create http folder
     */
    function initControllerFolder()
    {
        $this->createFolders($this->getControllerPath(), $this->getControllerName());
        $this->generateController();
    }

    /**
     * controller's namespace
     *
     * @return string
     */
    function getControllerNamespace()
    {
        return $this->getHttpNamespace();
    }

    /**
     * get the generated controller
     * @return string
     */
    function getGeneratedControllerName()
    {
        return isset($this->getConsole()->arguments()['class']) ? ucwords($this->sanitize($this->getConsole()->argument('class'))) : 'Controller';
    }

    /**
     * generate the controller of package
     */
    function generateController()
    {
        $content = $this->getAssetFile('Controller');
        $content = $this->replace($content, ['{controller_namespace}', '{package}', '{controller}'],
            [$this->getControllerNamespace(), $this->getPackageName(), $this->getGeneratedControllerName()]);
        file_put_contents($this->getControllerPath() . $this->fileSeparator() . $this->getGeneratedControllerName() . '.php', $content);
        $this->printConsole($msg ?? "< Controller > generated successfully");
    }
}