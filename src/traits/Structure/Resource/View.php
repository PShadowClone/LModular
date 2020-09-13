<?php


namespace Modular\traits\Structure\Resource;


trait View
{
    /**
     * returns the name of views folder
     * @return string
     */
    function getViewName()
    {
        return 'views';
    }

    /**
     * returns the full path of views folder
     * @return string
     */
    function getViewPath()
    {
        return $this->getResourcesPath() . $this->fileSeparator() . $this->getViewName();
    }

    /**
     * create views folder
     */
    function initViewFolder()
    {
        $this->createFolders($this->getViewPath(), $this->getViewName());
        $this->generateView();
    }

    /**
     * generate the view of package
     */
    function generateView()
    {
        $content = $this->getAssetFile('welcome');
        $content = $this->replace($content,
            ['{package}'],
            [$this->getPackageName()]);
        file_put_contents($this->getViewPath() . $this->fileSeparator() . 'welcome.blade.php', $content);
        $this->printConsole($msg ?? "< View > generated successfully");
    }
}