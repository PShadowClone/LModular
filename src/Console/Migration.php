<?php


namespace Modulars\Package\Console;


use Modulars\Package\Models\Package;
use Modulars\Package\Modular;

class Migration extends MasterConsole
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:migration {table} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration for package';

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
        $path = (new Package())->find($modular->getPackageName());
        $modular->setPackagePath($modular->basePath($path->getFullPath()));
        $modular->generateMigration();
    }
}
