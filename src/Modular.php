<?php


namespace Modulars\Package;


use Modulars\Package\traits\Asset;
use Modulars\Package\traits\Base;
use Modulars\Package\traits\Composer;
use Modulars\Package\traits\Controllers;
use Modulars\Package\traits\Destroy;
use Modulars\Package\traits\Init;
use Modulars\Package\traits\Package;
use Modulars\Package\traits\Register;
use Modulars\Package\traits\Structure;

class Modular
{
    use Base, Asset, Package, Structure, Composer, Register, Init, Destroy;

}