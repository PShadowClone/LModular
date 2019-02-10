<?php


namespace Modulars\Package\Models;


use Illuminate\Support\Facades\App;
use Modulars\Package\Console\MasterConsole;
use Modulars\Package\Console\PackageCommand;
use Modulars\Package\Exception\MasterDirException;

class PackageDir extends MasterDir
{
    private $command;
    private $lang;
    /**
     * package's src name
     */
    const SRC_PATH = "src";
    /**
     * package's controller dir. path
     */
    const CONTROLLER_PATH = self::SRC_PATH . "/Controllers";
    /**
     * package's models dir. path
     */
    const MODELS_PATH = self::SRC_PATH . "/Models";
    /**
     * package's middleware dir. path
     */
    const MIDDLEWARE_PATH = self::SRC_PATH . "/Middleware";
    /**
     * package's resource dir. path
     */
    const RESOURCE_PATH = self::SRC_PATH . "/Resources";
    /**
     * package's resource view dir. path
     */
    const RESOURCE_VIEWS_PATH = self::RESOURCE_PATH . "/views";
    /**
     * package's resource lang dir. path
     */
    const RESOURCE_LANG_PATH = self::RESOURCE_PATH . "/lang";
    /**
     * package's config dir. path
     */
    const CONFIG_PATH = self::SRC_PATH . "/Config";
    /**
     * package's migrations dir. path
     */
    const MIGRATION_PATH = self::SRC_PATH . "/Migrations";
    /**
     * package's service provider dir. path
     */
    const SERVICE_PROVIDER_PATH = self::SRC_PATH . "/Providers";
    /**
     * package's routes dir. path
     */
    const ROUTES_PATH = self::SRC_PATH . "/Routes";

    public function __construct($packageName, MasterConsole $command)
    {
        parent::__construct($packageName);
        $this->command = $command;
        $this->lang = App::getLocale();
    }

    /**
     * generate the package's composer file
     */
    private function copyComposer()
    {
        $composerPath = $this->getDir('composer.json', true);
        $packageComposerPath = $this->getPackagePath($this->getPackageName()) . '/composer.json';
        $composerContent = file_get_contents($composerPath);
        $composerContent = $this->replace($composerContent,
            ['{package_path_c}', '{package_path_o}', '{package_name}', '{library_name}'],
            [$this->getPSRNamespace(), strtolower($this->getPSRNamespace()), $this->getPackageName() . ' package', $this->getLibraryName()]
        );
        file_put_contents($packageComposerPath, $composerContent);
        $this->command->info($this->getPackageName() . ' : composer file generated successfully');
    }

    /**
     *
     * update the project composer
     *
     */
    private function updateFrameworkComposerFile()
    {
        $superComposer = file_get_contents($this->getDir('composer.json'));
        $content = json_decode($superComposer, true);
        $content['autoload-dev']['psr-4'][self::MASTER_DIR . '\\' . $this->getPackageName() . '\\'] = self::MASTER_DIR . '/' . $this->getPackageName() . '/src';
        $content = json_encode($content, JSON_PRETTY_PRINT);
        $content = $this->replace($content, '\/', '/');
        file_put_contents($this->getDir('composer.json'), $content);
        shell_exec('composer dump-autoload');
        $this->command->info($this->getPackageName() . ' : project composer updated successfully');
    }



    /**
     * create controller dir.
     */
    private function createControllerDir()
    {
        mkdir($this->getPackagePath($this->getPackageName()) . '/' . self::CONTROLLER_PATH);
        $this->command->info($this->getPackageName() . ' : controllers folder generated successfully');
    }

    /**
     * generate new Controller for the new package
     */
    private function generatePackageController()
    {
        $packageController = $this->getDir('PackageController.str', true);
        $packageControllerContents = file_get_contents($packageController);
        $newControllerContent = $this->replace($packageControllerContents,
            ['{package_controller_name}', '{package_name_space}', "{package_name}"],
            [$this->getPackageName() . "Controller", $this->getNameSpace(), $this->getPackageName()]);
        $packageController = $this->getPackagePath($this->getPackageName()) . '/' . self::CONTROLLER_PATH . '/' . $this->getPackageName() . 'Controller.php';
        file_put_contents($packageController, $newControllerContent);
        $this->command->info($this->getPackageName() . 'Controller generated successfully');

    }

    /**
     * create model's dir.
     */
    private function createModelDir()
    {
        mkdir($this->getPackagePath($this->getPackageName()) . '/' . self::MODELS_PATH);
        $this->command->info($this->getPackageName() . ' : Models folder generated successfully');
    }

    /**
     * generate new Controller for the new package
     */
    private function generatePackageModel()
    {
        $packageModel = $this->getDir('PackageModel.str', true);
        $packageModelContents = file_get_contents($packageModel);
        $newControllerContent = $this->replace($packageModelContents,
            ['{model_name}', '{package_name_space}', '{table_name}', '{primary_key}'],
            [$this->getPackageName(), $this->getNameSpace(), $this->getTableName(), $this->getPrimaryKey()]);
        $packageModel = $this->getPackagePath($this->getPackageName()) . '/' . self::MODELS_PATH . '/' . $this->getPackageName() . '.php';
        file_put_contents($packageModel, $newControllerContent);
        $this->command->info($this->getPackageName() . ': Model generated successfully');

    }

    /**
     * create middleware dir
     */
    private function createMiddlewareDir()
    {
        mkdir($this->getPackagePath($this->getPackageName()) . '/' . self::MIDDLEWARE_PATH);
        $this->command->info($this->getPackageName() . ' : Middleware folder generated successfully');
    }

    /**
     * generate new Controller for the new package
     */
    private function generatePackageMiddleware()
    {
        $packageModel = $this->getDir('PackageMiddleware.str', true);
        $packageModelContents = file_get_contents($packageModel);
        $newControllerContent = $this->replace($packageModelContents,
            ['{middleware_name}', '{package_name_space}'],
            [$this->getPackageName() . 'Middleware', $this->getNameSpace()]);
        $packageModel = $this->getPackagePath($this->getPackageName()) . '/' . self::MIDDLEWARE_PATH . '/' . $this->getPackageName() . 'Middleware.php';
        file_put_contents($packageModel, $newControllerContent);
        $this->command->info($this->getPackageName() . ': Middleware generated successfully');

    }

    /**
     * create middleware dir
     */
    private function createResourceDir()
    {
        mkdir($this->getPackagePath($this->getPackageName()) . '/' . self::RESOURCE_PATH);
        mkdir($this->getPackagePath($this->getPackageName()) . '/' . self::RESOURCE_VIEWS_PATH);
        mkdir($this->getPackagePath($this->getPackageName()) . '/' . self::RESOURCE_LANG_PATH);
        mkdir($this->getPackagePath($this->getPackageName()) . '/' . self::RESOURCE_LANG_PATH . '/' . $this->lang);
        $this->command->info($this->getPackageName() . ' : Resources folder generated successfully');
    }

    /**
     * generate new View for the new package
     */
    private function generatePackageView()
    {
        $packageModel = $this->getDir('welcome.str', true);
        $packageModelContents = file_get_contents($packageModel);
        $newControllerContent = $this->replace($packageModelContents,
            ['{package_name}'],
            [$this->getPackageName()]);
        $packageModel = $this->getPackagePath($this->getPackageName()) . '/' . self::RESOURCE_VIEWS_PATH . '/welcome.blade.php';
        file_put_contents($packageModel, $newControllerContent);
        $this->command->info($this->getPackageName() . ': view generated successfully');

    }

    /**
     * generate new Controller for the new package
     */
    private function generatePackageLang()
    {
        $packageModel = $this->getDir('lang.str', true);
        $packageModelContents = file_get_contents($packageModel);
        $newControllerContent = $this->replace($packageModelContents,
            ['{package_name}'],
            [$this->getPackageName()]);
        $packageModel = $this->getPackagePath($this->getPackageName()) . '/' . self::RESOURCE_LANG_PATH . '/' . $this->lang . '/lang.php';
        file_put_contents($packageModel, $newControllerContent);
        $this->command->info($this->getPackageName() . ': lang generated successfully');

    }

    /**
     * create middleware dir
     */
    private function createConfigDir()
    {
        mkdir($this->getPackagePath($this->getPackageName()) . '/' . self::CONFIG_PATH);
        $this->command->info($this->getPackageName() . ' : Config folder generated successfully');
    }

    /**
     * generate new Controller for the new package
     */
    private function generatePackageConfiguration()
    {
        $packageModel = $this->getDir('config.str', true);
        $packageModelContents = file_get_contents($packageModel);
        $packageModel = $this->getPackagePath($this->getPackageName()) . '/' . self::CONFIG_PATH . '/' . $this->getConfigurationName() . '.php';
        file_put_contents($packageModel, $packageModelContents);
        $this->command->info($this->getPackageName() . ': Configuration file generated successfully');

    }

    /**
     * create middleware dir
     */
    private function createMigrationDir()
    {
        mkdir($this->getPackagePath($this->getPackageName()) . '/' . self::MIGRATION_PATH);
        $this->command->info($this->getPackageName() . ' : Migrations folder generated successfully');
    }

    /**
     * generate new Controller for the new package
     */
    private function generatePackageMigration()
    {
        $packageModel = $this->getDir('PackageMigration.str', true);
        $packageModelContents = file_get_contents($packageModel);
        $newControllerContent = $this->replace($packageModelContents,
            ['{package_name_space}', '{table_name}', '{migration_name}'],
            [$this->getNameSpace(), $this->getTableName(), 'Create' . $this->getPackageName() . 'Table']);
        $packageModel = $this->getPackagePath($this->getPackageName()) . '/' . self::MIGRATION_PATH . '/' . $this->getMigrationName() . '.php';
        file_put_contents($packageModel, $newControllerContent);
        $this->command->info($this->getPackageName() . ': Migration generated successfully');

    }

    /**
     * create middleware dir
     */
    private function createServiceProviderDir()
    {
        mkdir($this->getPackagePath($this->getPackageName()) . '/' . self::SERVICE_PROVIDER_PATH);
        $this->command->info($this->getPackageName() . ' : Service Provider folder generated successfully');
    }

    /**
     * generate new Service Provider for the new package
     */
    private function generatePackageServiceProvider()
    {
        $packageModel = $this->getDir('ServiceProvider.str', true);
        $packageModelContents = file_get_contents($packageModel);
        $newControllerContent = $this->replace($packageModelContents,
            ['{package_name_space}', '{service_provider_name}', '{package_conf_name}', '{package_name}'],
            [$this->getNameSpace(), $this->getPackageName() . 'ServiceProvider', $this->getConfigurationName(), $this->getPackageName()]);
        $packageModel = $this->getPackagePath($this->getPackageName()) . '/' . self::SERVICE_PROVIDER_PATH . '/' . $this->getPackageName() . 'ServiceProvider.php';
        file_put_contents($packageModel, $newControllerContent);
        $this->command->info($this->getPackageName() . ': Service Provider generated successfully');

    }

    /**
     * create middleware dir
     */
    private function createRoutesDir()
    {
        mkdir($this->getPackagePath($this->getPackageName()) . '/' . self::ROUTES_PATH);
        $this->command->info($this->getPackageName() . ' : Route folder generated successfully');
    }

    /**
     * generate new Controller for the new package
     */
    private function generatePackageRoutes()
    {
        $packageModel = $this->getDir('route.str', true);
        $packageModelContents = file_get_contents($packageModel);
        $newControllerContent = $this->replace($packageModelContents,
            ['{package_name_space}', '{controller_name}', '{url_name}'],
            [$this->getNameSpace(), $this->getControllerName(), strtolower($this->getPackageName())]);
        $packageModel = $this->getPackagePath($this->getPackageName()) . '/' . self::ROUTES_PATH . '/web.php';
        file_put_contents($packageModel, $newControllerContent);
        $this->command->info($this->getPackageName() . ': web route generated successfully');

    }


    /**
     * add package's service provider into app config file
     */
    private function getFrameworkServiceProvider()
    {
        $result = file_get_contents($this->getDir('config/app.php'));
        $newServiceProvider = $this->getNameSpace() . '\\Providers' . '\\' . $this->getPackageName() . 'ServiceProvider';
        $newContent = $this->replace($result, $this->getProviderStartingExpression(), $this->getProviderStartingExpression() . '
        ' . $newServiceProvider . '::class,');
        file_put_contents($this->getDir('config/app.php'), $newContent);
    }


    private function createdFolders()
    {
        return [
            'Controller', 'Model', 'Middleware', 'Resource', 'Config', 'Migration', 'ServiceProvider', 'Routes'
        ];
    }

    private function generatedFiles()
    {
        return ['PackageController', 'PackageModel', 'PackageMiddleware', 'PackageView', 'PackageLang', 'PackageConfiguration', 'PackageMigration', 'PackageRoutes',
            'PackageServiceProvider'];
    }


    /**
     * generate src dir for package
     */
    private function createSrcDir()
    {

        mkdir($this->getPackagePath($this->getPackageName()) . '/' . self::SRC_PATH);
        $this->command->info($this->getPackageName() . ' : src folder generated successfully');
        $createdFolders = $this->createdFolders();
        foreach ($createdFolders as $folder){
            $functionName= 'create'.$folder.'Dir';
            $this->$functionName();
        }
        $generatedFiles = $this->generatedFiles();
        foreach ($generatedFiles as $file){
            $functionName= 'generate'.$file;
            $this->$functionName();
        }
        $this->getFrameworkServiceProvider();
    }


    public function createPackage()
    {
        $this->copyComposer();

        $this->createSrcDir();

        $this->updateFrameworkComposerFile();
    }
}