<?php


namespace Modular\Console;


use Modular\Models\Package;
use Modular\Modular;

class Request extends MasterConsole
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:request {request} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new request for package';

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
        $modular->generateRequest();
    }
}