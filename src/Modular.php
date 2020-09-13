<?php


namespace Modular;


use Modular\traits\Asset;
use Modular\traits\Base;
use Modular\traits\Composer;
use Modular\traits\Controllers;
use Modular\traits\Destroy;
use Modular\traits\Init;
use Modular\traits\Package;
use Modular\traits\Register;
use Modular\traits\Structure;

class Modular
{
    use Base, Asset, Package, Structure, Composer, Register, Init, Destroy;

}