<?php

namespace Modular\Package;

use \Illuminate\Support\ServiceProvider;
use Modular\Package\Console\DeletePackage;
use Modular\Package\Console\ListPackages;
use Modular\Package\Console\PackageCommand;

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