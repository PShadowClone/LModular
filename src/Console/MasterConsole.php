<?php

namespace Modular\Console;

use Illuminate\Console\Command;
use Modular\Exception\MasterDirException;
use Modular\Models\Package;


class MasterConsole extends Command
{

    /**
     * the pattern of package name
     */
    const PACKAGE_NAME_PATTERN = "/^[a-zA-Z]+$/";

    /**
     * print the required messages
     *
     * @param $message
     * @param $flag
     */
    protected function printMessage($message, $flag)
    {
        try {
            $this->$flag($message);
        } catch (\Exception $exception) {
            $this->error('Something went wrong while printing user\'s message');
        }
    }

    /**
     * find package
     *
     * @param $name
     * @param $path
     * @return mixed
     */
    protected function findPackage($name, $path)
    {
        return (new Package())->find($name, $path);
    }


}