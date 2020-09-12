<?php

namespace Modulars\Package\Provider;

use \Illuminate\Support\ServiceProvider;
use Modulars\Package\Console\Controller;
use Modulars\Package\Console\DeletePackage;
use Modulars\Package\Console\ListPackages;
use Modulars\Package\Console\Middleware;
use Modulars\Package\Console\Migration;
use Modulars\Package\Console\Model;
use Modulars\Package\Console\PackageCommand;
use Modulars\Package\Console\Repository;


class ModularServiceProvider extends ServiceProvider
{


    public function boot()
    {
        // publish the command of package
        if ($this->app->runningInConsole()) {
            $this->commands([
                PackageCommand::class,
                ListPackages::class,
                DeletePackage::class,
                Model::class,
                Controller::class,
                Repository::class,
                Middleware::class,
                Migration::class
            ]);
        }
    }


    public function register()
    {
    }


}