<?php

namespace Modulars\Package;

use \Illuminate\Support\ServiceProvider;
use Modulars\Package\Console\DeletePackage;
use Modulars\Package\Console\ListPackages;
use Modulars\Package\Console\PackageCommand;

class ModularServiceProvider extends ServiceProvider
{


    public function boot()
    {
        // publish the command of package
        if ($this->app->runningInConsole()) {
            $this->commands([
                PackageCommand::class,
                ListPackages::class,
                DeletePackage::class
            ]);
        }
    }


    public function register()
    {
    }


}