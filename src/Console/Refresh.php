<?php


namespace Modular\Console;


use Modular\Models\Package;
use Modular\Modular;

class Refresh extends MasterConsole
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-register all generated packages';

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
        $path = new Package();
        $path->refresh();
        $this->info("Configurations refreshed successfully!");
    }
}