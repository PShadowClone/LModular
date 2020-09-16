<?php


namespace Modular\traits;


trait Composer
{

    /**
     *
     * update the project composer
     *
     */
    private function updateFrameworkComposerFile()
    {
        $superComposer = file_get_contents(base_path('composer.json'));
        $content = json_decode($superComposer, true);
        $content['autoload-dev']['psr-4'][$this->getPackageName() . '\\' . 'App' . '\\'] =
            $this->getMasterFolder() . $this->fileSeparator() . $this->getPackageName() . $this->fileSeparator() . 'app';
        $content = json_encode($content, JSON_PRETTY_PRINT);
        $content = $this->replace($content, '\/', '/');
        file_put_contents(base_path('composer.json'), $content);
        shell_exec('composer dump-autoload');
        $this->printConsole($msg ?? "< Composer > generated successfully");
    }

    /**
     * generate the composer of package
     */
    function generateComposer()
    {
        $content = $this->getAssetFile('composer');
        $content = $this->replace($content,
            ['{package}', '{package_name}'],
            [$this->getPackageName(),strtolower($this->getPackageName())]);
        file_put_contents($this->getPackagePath() . $this->fileSeparator() . 'composer.json', $content);
        $this->printConsole($msg ?? "< Composer > generated successfully");
        $this->updateFrameworkComposerFile();
    }


    /**
     *
     * remove package's reference from the project composer
     *
     */
    function removeFrameworkComposerFile()
    {
        $superComposer = file_get_contents(base_path('composer.json'));
        $content = json_decode($superComposer, true);
        unset($content['autoload-dev']['psr-4'][$this->getPackageName() . '\\' . 'App' . '\\']);
        $content = json_encode($content, JSON_PRETTY_PRINT);
        $content = $this->replace($content, '\/', '/');
        file_put_contents(base_path('composer.json'), $content);
        shell_exec('composer dump-autoload');
        $this->printConsole($msg ?? "< Composer > generated successfully");
    }
}