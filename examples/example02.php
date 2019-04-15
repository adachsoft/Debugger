<?php
use AdachSoft\Debugger\Debugger;
use AdachSoft\Debugger\LogPrint;
use AdachSoft\Debugger\ParserVarDump;
use AdachSoft\Debugger\LogHtml;
use AdachSoft\Debugger\LogToServer;
use AdachSoft\Debugger\ParserPrintR;
use AdachSoft\Debugger\Deb;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../src/SingletonTrait.php';
include '../src/Debugger.php';
include '../src/LogInterface.php';
include '../src/LogPrint.php';
include '../src/LogHtml.php';
include '../src/LogToServer.php';
include '../src/ParserInterface.php';
include '../src/ParserVarDump.php';
include '../src/ParserPrintR.php';
include '../src/Deb.php';


Deb::get()->setErrorHandler();


$t = $r + $b;
echo $g;