<?php


namespace Modulars\Package\Exception;


use Throwable;

class MasterDirException extends \Exception
{


    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}