<?php


namespace Modular\traits\Structure;


trait Config
{
    /**
     * returns the name of config folder
     * @return string
     */
    function getConfigName()
    {
        return 'config';
    }

    /**
     * returns the full path of config folder
     * @return string
     */
    function getConfigPath()
    {
        return $this->getPackagePath() . $this->fileSeparator() . $this->getConfigName();
    }

    /**
     * create config folder
     */
    function initConfigFolder()
    {
        $this->createFolders($this->getConfigPath(), $this->getConfigName());
        $this->generateConfig();
    }

    /**
     * generate the config of package
     */
    function generateConfig()
    {
        $content = $this->getAssetFile('config');
        file_put_contents($this->getConfigPath() . $this->fileSeparator() . $this->getPackageName() . '.php', $content);
        $this->printConsole($msg ?? "< Config > generated successfully");
    }
}