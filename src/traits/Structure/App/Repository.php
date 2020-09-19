<?php


namespace Modular\traits\Structure\App;


trait Repository
{
    /**
     * returns the name of repositories folder
     * @return string
     */
    function getRepositoryName()
    {
        return 'Repositories';
    }

    /**
     * returns the full path of repositories folder
     * @return string
     */
    function getRepositoryPath()
    {
        return $this->getAppPath() . $this->fileSeparator() . $this->getRepositoryName();
    }

    /**
     * create repositories folder
     */
    function initRepositoryFolder()
    {
        $this->createFolders($this->getRepositoryPath(), $this->getRepositoryName());
        $this->generateRepository();
    }

    /**
     * repository's namespace
     *
     * @return string
     */
    function getRepositoryNamespace()
    {
        return $this->getAppNamespace() . '\App';
    }

    /**
     * get the generated repo
     * @return string
     */
    function getGeneratedRepositoryName()
    {
        return isset($this->getConsole()->arguments()['class']) ? ucwords($this->sanitize($this->getConsole()->argument('class'))) : 'Repository';
    }

    /**
     * generate the repository of package
     */
    function generateRepository()
    {
        $content = $this->getAssetFile('Repository');
        $content = $this->replace($content,
            ['{repository_namespace}', '{repository}'],
            [$this->getRepositoryNamespace(), $this->getGeneratedRepositoryName()]);
        file_put_contents($this->getRepositoryPath() . $this->fileSeparator() . $this->getGeneratedRepositoryName() . '.php', $content);
        $this->printConsole($msg ?? "< Repository > generated successfully");
    }
}