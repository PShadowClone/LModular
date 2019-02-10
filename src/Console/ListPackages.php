<?php

namespace Modulars\Package\Console;

use Illuminate\Console\Command;
use Modulars\Package\Models\ShowPackages;


class ListPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all generated packages';

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
        $showPackage = new ShowPackages(null);
        $packages = $showPackage->getListedPackages();

        $this->printBody($packages);
    }

    /**
     * print the header of shape
     * @param $starsOfLongestPackage
     * @param $length
     */
    private function header($starsOfLongestPackage, $length)
    {
        $this->info("* " . "*" . " * " . $starsOfLongestPackage . " * ");
        $space = floor($length / 2) - 2;
        $spaces = str_repeat(" ", $space);
        $this->info("* " . "*" . " * " . $spaces . 'Packages' . $spaces . "* ");
        $this->info("* " . "*" . " * " . $starsOfLongestPackage . " * ");

    }

    /**
     * print the name of packages
     * @param $packages
     */
    private function printBody($packages)
    {
        $longestPackages = max(array_map('strlen', $packages));
        $starsOfLongestPackage = str_repeat("*", ($longestPackages + 2));
        $this->header($starsOfLongestPackage, $longestPackages);
        for ($counter = 0; $counter < sizeof($packages); $counter++) {
            $packageNameLength = strlen($packages[$counter]);
            $space = $longestPackages - $packageNameLength;
            if ($space == 0)
                $space = '';
            else
                $space = str_repeat(" ", ($space)) . "";
            $this->info("* " . ($counter + 1) . " * \t" . $packages[$counter] . $space . " * ");

        }
        $this->footer($starsOfLongestPackage);

    }

    /**
     * print the footer of shape
     * @param $starsOfLongestPackage
     */
    private function footer($starsOfLongestPackage)
    {
        $this->info("* " . "*" . " * " . $starsOfLongestPackage . " * ");
    }
}