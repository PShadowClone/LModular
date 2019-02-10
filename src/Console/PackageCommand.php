<?php

namespace Modulars\Package\Console;


use Modulars\Package\Exception\MasterDirException;
use Modulars\Package\Models\MasterDir;
use Modulars\Package\Models\PackageDir;

class PackageCommand extends MasterConsole
{


    private $masterDir;

    private $packageDir;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new package';

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
        $this->packageDir = new PackageDir($this->argument('name'), $this);
        try {
            $result = $this->packageDir->createDirs(MasterDir::MASTER_DIR, true);
            if ($result == MasterDir::NOT_EXISTED_DIR)
                $this->printMessage('Master package created successfully', 'info');
            $packageName = $this->argument('name');
            if (!preg_match(self::PACKAGE_NAME_PATTERN, $packageName)) {
                $this->printMessage('Invalid package\'s name', 'error');
                return;
            }
            $packageName = $this->packageDir->getPackageName();
            $result = $this->packageDir->createDirs($packageName);
            if ($result != MasterDir::NOT_EXISTED_DIR) {
                $this->printMessage($packageName . ' package is already existed', 'error');
                return;
            }
            $this->printMessage($packageName . ' created successfully', 'info');
            $this->packageDir->createPackage();

        } catch (MasterDirException $dirException) {
            $this->printMessage('Something went wrong while creating ' . $this->argument('name') . " package", 'error');
        }
    }


}