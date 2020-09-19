<?php


namespace Modular\traits\Structure\App\Http;


trait Middleware
{
    /**
     * returns the name of middleware folder
     * @return string
     */
    function getMiddlewareName()
    {
        return 'Middleware';
    }

    /**
     * returns the full path of middleware folder
     * @return string
     */
    function getMiddlewarePath()
    {
        return $this->getHttpPath() . $this->fileSeparator() . $this->getMiddlewareName();
    }

    /**
     * create middleware folder
     */
    function initMiddlewareFolder()
    {
        $this->createFolders($this->getMiddlewarePath(), $this->getMiddlewareName());
        $this->generateMiddleware();
    }


    /**
     * middleware's namespace
     *
     * @return string
     */
    function getMiddlewareNamespace()
    {
        return $this->getHttpNamespace();
    }

    /**
     * get the generated middleware
     * @return string
     */
    function getGeneratedMiddlewareName()
    {
        return isset($this->getConsole()->arguments()['class']) ? ucwords($this->sanitize($this->getConsole()->argument('class'))) : 'Middleware';
    }

    /**
     * generate the middleware of package
     */
    function generateMiddleware()
    {
        $content = $this->getAssetFile('Middleware');
        $content = $this->replace($content, ['{middleware_namespace}', '{package}', '{middleware}'],
            [$this->getMiddlewareNamespace(), $this->getPackageName(), $this->getGeneratedMiddlewareName()]);
        file_put_contents($this->getMiddlewarePath() . $this->fileSeparator() . $this->getGeneratedMiddlewareName() . '.php', $content);
        $this->printConsole($msg ?? "< Middleware > generated successfully");
    }
}