<?php


namespace Modular\traits\Structure;


trait Database
{
    /**
     * returns the name of database folder
     * @return string
     */
    function getDatabasesName()
    {
        return 'database' . $this->fileSeparator() . 'migrations';
    }

    /**
     * returns the full path of database folder
     * @return string
     */
    function getDatabasesPath()
    {
        return $this->getPackagePath() . $this->fileSeparator() . $this->getDatabasesName();
    }

    /**
     * create database folder
     */
    function initDatabasesFolder()
    {
        $this->createFolders($this->getDatabasesPath(), $this->getDatabasesName());
        $this->generateMigration();

    }

    /**
     * get the generated migration
     * @return string
     */
    function getGeneratedMigrationName($plural = false)
    {
        if (!isset($this->getConsole()->arguments()['table']))
            return $this->getPackageName($plural);
        $name = $this->sanitize($this->getConsole()->argument('table'));
        return $plural ? $this->str_plural($name) : ucwords($name);
    }

    /**
     * get migration name
     *
     * @param bool $purpose
     * @return string
     */
    function getMigrationName($purpose = true)
    {
        $functionName = 'create';
        if (!$purpose)
            $functionName = 'update';
        return date('Y_m_d') . '_00000_' . $functionName . '_' . $this->getGeneratedMigrationName(false) . '_' . 'table';
    }


    /**
     * generate the migration of package
     */
    function generateMigration()
    {
        $content = $this->getAssetFile('Migration');
        $content = $this->replace($content,
            ['{package}', "{table_name}"],
            [$this->getGeneratedMigrationName(), $this->getGeneratedMigrationName(true)]);
        file_put_contents($this->getDatabasesPath() . $this->fileSeparator() . $this->getMigrationName() . '.php', $content);
        $this->printConsole($msg ?? "< Migration > generated successfully");
    }
}