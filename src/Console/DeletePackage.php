<?php


namespace Modular\Console;

use Modular\Modular;

class DeletePackage extends MasterConsole
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:delete {name} {--path=}';

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
            $this->error('Could not remove the package, or package is not existed');
        }
    }


}