<?php


namespace Modular\traits\Package;


use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait Config
{
    /**
     * project's composer file
     *
     * @return string
     */
    private function __getProjectComposerPath()
    {
        return base_path('composer.json');
    }

    /**
     * read the content of composer and return it
     * as a collection
     * @return \Illuminate\Support\Collection
     */
    private function __getProjectComposer()
    {
        $path = $this->__getProjectComposerPath();
        return collect(json_decode(file_get_contents($path), true));
    }

    /**
     * read autoload-dev contents
     * @return \Illuminate\Support\Collection
     */
    private function __getAutoloadDev()
    {
        $composer = $this->__getProjectComposer();
        return collect($composer->get('autoload-dev'));
    }

    /**
     * get packages paths
     * @return \Illuminate\Support\Collection
     */
    private function __getPackagesPaths()
    {
        return $this->__getPsr4()
            ->filter(function ($value, $key) {
                return Str::contains($key, 'App');
            })->map(function ($value) {
                return Str::replaceLast('/app', '', $value);
            })->values();
    }

    /**
     * check if the pages i got, are valid by checking
     * composer.json file
     *
     * @return \Illuminate\Support\Collection
     */
    private function __realPackages()
    {
        return collect($this->__getPackagesPaths())
            ->filter(function ($path) {
                return File::exists(base_path($path . $this->fileSeparator() . 'composer.json'));
            });
    }

    /**
     * read psr-4 contents
     * @return \Illuminate\Support\Collection
     */
    private function __getPsr4()
    {
        return collect($this->__getAutoloadDev()->get('psr-4'));
    }

    /**
     * extracts package's name form package path
     * @param $package
     * @return mixed
     */
    private function __extractPackageName($package)
    {
        $packagePath = explode($this->fileSeparator(), $package);
        return end($packagePath);
    }

    /**
     * fill packages data in separated objects
     * @return \Illuminate\Support\Collection
     */
    private function __preparePackages()
    {
        return $this->__realPackages()->map(function ($package) {
            $packageObject = new self();
            $packageObject->fill([
                'package' => $this->__extractPackageName($package),
                'fullPath' => $package,
                'createdAt' => Carbon::now()
            ]);
            return $packageObject;
        });
    }

    /**
     * return packages
     * @return \Illuminate\Support\Collection
     */
    private function packages()
    {
        return $this->__preparePackages();
    }


}