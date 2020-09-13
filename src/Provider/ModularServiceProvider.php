<?php

namespace Modular\Provider;

use \Illuminate\Support\ServiceProvider;
use Modular\Console\Controller;
use Modular\Console\DeletePackage;
use Modular\Console\ListPackages;
use Modular\Console\Middleware;
use Modular\Console\Migration;
use Modular\Console\Model;
use Modular\Console\PackageCommand;
use Modular\Console\Repository;


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