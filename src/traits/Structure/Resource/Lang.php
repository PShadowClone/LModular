<?php


namespace Modulars\Package\traits\Structure\Resource;


trait Lang
{
    /**
     * returns the name of lang folder
     * @return string
     */
    function getLangName()
    {
        return 'lang';
    }

    /**
     * returns the full path of views folder
     * @return string
     */
    function getLangPath()
    {
        return $this->getResourcesPath() . $this->fileSeparator() . $this->getLangName();
    }

    /**
     * create views folder
     */
    function initLangFolder()
    {
        $this->createFolders($this->getLangPath(), $this->getLangName());
        $this->initEnFolder();
    }

    /**
     * returns the name of en folder
     * @return string
     */
    function getEnName()
    {
        return 'en';
    }

    /**
     * returns the full path of en folder
     * @return string
     */
    function getEnPath()
    {
        return $this->getLangPath() . $this->fileSeparator() . $this->getEnName();
    }

    /**
     * create lang folder
     */
    function initEnFolder()
    {
        $this->createFolders($this->getEnPath(), $this->getEnName());
        $this->generateLang();
    }


    /**
     * generate the lang of package
     */
    function generateLang()
    {
        $content = $this->getAssetFile('lang');
        $content = $this->replace($content,
            ['{package}'],
            [$this->getPackageName()]);
        file_put_contents($this->getEnPath() . $this->fileSeparator() . 'lang.php', $content);
        $this->printConsole($msg ?? "< Lang > generated successfully");
    }
}