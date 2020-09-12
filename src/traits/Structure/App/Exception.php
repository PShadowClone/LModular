<?php


namespace Modulars\Package\traits\Structure\App;


trait Exception
{
    /**
     * returns the name of exceptions folder
     * @return string
     */
    function getExceptionName()
    {
        return 'Exceptions';
    }

    /**
     * returns the full path of exceptions folder
     * @return string
     */
    function getExceptionPath()
    {
        return $this->getAppPath() . $this->fileSeparator() . $this->getExceptionName();
    }

    /**
     * create exceptions folder
     */
    function initExceptionFolder()
    {
        $this->createFolders($this->getExceptionPath(), $this->getExceptionName());
        $this->generateException();
    }

    /**
     * exception's namespace
     *
     * @return string
     */
    function getExceptionNamespace()
    {
        return $this->getPackageName() . '\App';
    }

    /**
     * generate the exception of package
     */
    function generateException()
    {
        $content = $this->getAssetFile('Exception');
        $content = $this->replace($content,
            ['{exception_namespace}'],
            [$this->getExceptionNamespace()]);
        file_put_contents($this->getExceptionPath() . $this->fileSeparator() . 'Handler.php', $content);
        $this->printConsole($msg ?? "< Exception > generated successfully");
    }
}