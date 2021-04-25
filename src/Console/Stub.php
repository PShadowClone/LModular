<?php


namespace Modular\Console;


use Modular\Modular;

class Stub extends MasterConsole
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:stubs {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish stubs templates';

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
        $stub = new \Modular\Stub($this);
        $stub->publish();


    }

}