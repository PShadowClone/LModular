<?php

namespace Modular\Package\Console;

use Illuminate\Console\Command;
use Modular\Package\Exception\MasterDirException;


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


}