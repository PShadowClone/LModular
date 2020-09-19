<?php


namespace Modular\Exception;


class PackageAlreadyExisted extends \Exception
{
    protected $message = 'package already existed';
}