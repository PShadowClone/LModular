<?php

namespace Modular\Console;

use Modular\Modular;

class PackageCommand extends MasterConsole
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:create {name} {--path=}';

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
        $modular = new Modular($this);
        $modular->init();
    }


}