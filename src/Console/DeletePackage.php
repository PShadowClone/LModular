<?php


namespace Modulars\Package\Console;

use Illuminate\Console\Command;
use Modulars\Package\Models\DeletePackageModel;
use Modulars\Package\Models\MasterDir;
use Modulars\Package\Models\PackageDir;
use Modulars\Package\Models\ShowPackages;
use Modulars\Package\Modular;

class DeletePackage extends MasterConsole
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:delete {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete package';

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
        try {
            $modular = new Modular($this);
            $modular->destroy();
        } catch (\Exception $exception) {
            $this->error('Could not remove the package');
        }
    }


}