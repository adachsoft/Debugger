<?php

use AdachSoft\Debugger\Deb;

include '../vendor/autoload.php';

test1();

function test1()
{
    test2();
}

function test2()
{
    test3();
}

function test3()
{
    Deb::get()->backTrace();
}