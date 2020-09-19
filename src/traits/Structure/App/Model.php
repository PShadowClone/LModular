<?php


namespace Modular\traits\Structure\App;


trait Model
{
    /**
     * returns the name of models folder
     * @return string
     */
    function getModelName()
    {
        return 'Models';
    }

    /**
     * returns the full path of models folder
     * @return string
     */
    function getModelPath()
    {
        return $this->getAppPath() . $this->fileSeparator() . $this->getModelName();
    }

    /**
     * create exceptions folder
     */
    function initModelFolder()
    {
        $this->createFolders($this->getModelPath(), $this->getModelName());
        $this->generateModel();
    }

    /**
     * model's namespace
     *
     * @return string
     */
    function getModelNamespace()
    {
        return $this->getAppNamespace();
    }

    /**
     * get the generated model
     * @return string
     */
    function getGeneratedModelName()
    {
        return isset($this->getConsole()->arguments()['class']) ? ucwords($this->sanitize($this->getConsole()->argument('class'))) : $this->getPackageName();
    }

    /**
     * generate the model of package
     */
    function generateModel()
    {
        $content = $this->getAssetFile('Model');
        $content = $this->replace($content,
            ['{model_namespace}', '{package}', "{table_name}"],
            [$this->getModelNamespace(), $this->getGeneratedModelName(), strtolower($this->str_plural($this->getGeneratedModelName()))]);
        file_put_contents($this->getModelPath() . $this->fileSeparator() . $this->getGeneratedModelName() . '.php', $content);
        $this->printConsole($msg ?? "< Model > generated successfully");
    }
}