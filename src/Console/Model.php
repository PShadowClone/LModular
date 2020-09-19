<?php


namespace Modular\Console;


use Modular\Models\Package;
use Modular\Modular;

class Model extends MasterConsole
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:model {class} {name} {--path=} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model for package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $modular = new Modular($this);
        $path = $this->findPackage($modular->getPackageName(), $modular->getPath());
        $modular->setPackagePath($modular->basePath($path->getFullPath()));
        if ($this->option('all'))
            $modular->initPackageClasses();
        else
            $modular->generateModel();
    }
}