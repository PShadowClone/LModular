<?php


namespace Modular\traits\Structure;


trait Route
{
    /**
     * returns the name of routes folder
     * @return string
     */
    function getRoutesName()
    {
        return 'routes';
    }

    /**
     * returns the full path of routes folder
     * @return string
     */
    function getRoutesPath()
    {
        return $this->getPackagePath() . $this->fileSeparator() . $this->getRoutesName();
    }

    /**
     * create routes folder
     */
    function initRoutesFolder()
    {
        $this->createFolders($this->getRoutesPath(), $this->getRoutesName());
        $content = $this->getRouteContent();
        array_map(function ($type) use ($content) {
            $this->generateRoutes($type, $content);
        }, $this->supportedRoutes());
    }

    /**
     * route content
     *
     * @return mixed
     */
    function getRouteContent()
    {
        return $this->getAssetFile('route');
    }


    /**
     * generate the model of package
     */
    function generateRoutes($type, $content)
    {
        $content = $this->replace($content,
            ['{package}', "{type}"],
            [$this->getPackageName(), $type]);
        file_put_contents($this->getRoutesPath() . $this->fileSeparator() . $type . '.php', $content);
        $this->printConsole($msg ?? "< $type > generated successfully");
    }

    /**
     * supported routes
     *
     * @return array
     */
    function supportedRoutes()
    {
        return ['api', 'mobile', 'web'];
    }
}