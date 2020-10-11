<?php


namespace Modular\traits\Structure;


use Illuminate\Support\Str;

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
     * returns the name of database folder
     * @return string
     */
    function getSeedsName()
    {
        return 'database' . $this->fileSeparator() . 'seeds';
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
     * returns the full path of seeds folder
     * @return string
     */
    function getSeedsPath()
    {
        return $this->getPackagePath() . $this->fileSeparator() . $this->getSeedsName();
    }

    /**
     * create database folder
     */
    function initDatabasesFolder()
    {
        $this->createFolders($this->getDatabasesPath(), $this->getDatabasesName());
        $this->createFolders($this->getSeedsPath(), $this->getSeedsName());
        $this->generateMigration();
        $this->generateSeeds();

    }

    /**
     * get the generated migration
     * @return string
     */
    function getGeneratedMigrationName($plural = false)
    {
        if (!isset($this->getConsole()->arguments()['class']))
            return $this->getPackageName($plural);
        $name = $this->sanitize($this->getConsole()->argument('class'));
        return $plural ? $this->str_plural($name) : ucwords($name);
    }


    /**
     * get the generated seeder
     * @return string
     */
    function getGeneratedSeederName($plural = false)
    {
        if (!isset($this->getConsole()->arguments()['class']))
            return $this->getPackageName($plural);
        $name = $this->sanitize($this->getConsole()->argument('class'));
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
        return date('Y_m_d') . '_00000_' . $functionName . '_' . Str::lower($this->getGeneratedMigrationName(false)) . '_' . 'table';
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

    /**
     * generate the migration of package
     */
    function generateSeeds()
    {
        $content = $this->getAssetFile('Seeder');
        $content = $this->replace($content,
            ['{package}'],
            [$this->getGeneratedSeederName()]);
        file_put_contents($this->getSeedsPath() . $this->fileSeparator() . $this->getGeneratedSeederName() . 'SeederTable.php', $content);
        $this->printConsole($msg ?? "< Seeder > generated successfully");
    }
}