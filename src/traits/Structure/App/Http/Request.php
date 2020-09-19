<?php


namespace Modular\traits\Structure\App\Http;


trait Request
{
    /**
     * returns the name of Requests folder
     * @return string
     */
    function getRequestName()
    {
        return 'Requests';
    }

    /**
     * returns the full path of http folder
     * @return string
     */
    function getRequestPath()
    {
        return $this->getHttpPath() . $this->fileSeparator() . $this->getRequestName();
    }

    /**
     * create http folder
     */
    function initRequestFolder()
    {
        $this->createFolders($this->getRequestPath(), $this->getRequestName());
        $this->generateRequest();
    }

    /**
     * Request's namespace
     *
     * @return string
     */
    function getRequestNamespace()
    {
        return $this->getHttpNamespace();
    }

    /**
     * get the generated Request
     * @return string
     */
    function getGeneratedRequestName()
    {
        return isset($this->getConsole()->arguments()['request']) ? ucwords($this->sanitize($this->getConsole()->argument('request'))) : 'Request';
    }

    /**
     * generate the Request of package
     */
    function generateRequest()
    {
        $content = $this->getAssetFile('Request');
        $content = $this->replace($content, ['{request_namespace}', '{package}', '{request}'],
            [$this->getRequestNamespace(), $this->getPackageName(), $this->getGeneratedRequestName()]);
        file_put_contents($this->getRequestPath() . $this->fileSeparator() . $this->getGeneratedRequestName() . '.php', $content);
        $this->printConsole($msg ?? "< Request > generated successfully");
    }
}