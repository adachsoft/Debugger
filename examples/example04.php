<?php

use AdachSoft\Debugger\Deb;

include '../vendor/autoload.php';

Deb::getTypeWithoutValue()->varDump([12, 72, 360]);
Deb::getTypeWithoutValue()->varDump(72.12);
Deb::getTypeWithoutValue()->varDump(null);
Deb::getTypeWithoutValue()->varDump(2160);
Deb::getTypeWithoutValue()->varDump('test');

Deb::getTypeWithoutValue()->varDump('test', 432, 1.618, []);
