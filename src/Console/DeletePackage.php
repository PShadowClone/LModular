<?php


namespace Modulars\Package\Console;

use Illuminate\Console\Command;
use Modulars\Package\Models\DeletePackageModel;
use Modulars\Package\Models\MasterDir;
use Modulars\Package\Models\PackageDir;
use Modulars\Package\Models\ShowPackages;

class DeletePackage extends MasterConsole
{
    private $deletePackage;

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
        $this->deletePackage = new DeletePackageModel($this->argument('name'), $this);
        $result = $this->deletePackage->delete();
        $packageName = $this->deletePackage->getPackageName();
        if ($result == MasterDir::NOT_EXISTED_DIR) {
            $this->error('Package ' . $packageName . ' is not existed');
            return;
        }
        if ($result == 0) {
            $this->error('Something went wrong while removing ' . $packageName . " packages directory");
            return;
        }
        $this->info('Package ' . $packageName . ' has been removed successfully');
    }


}