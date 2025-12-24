#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Simple TCP log server.
 *
 * Equivalent of: ncat -lk 2160
 *
 * Usage:
 *   php bin/server.php [--host=127.0.0.1] [--port=2160] [--buffer_size=1048576] [--colors=0|1]
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Adachsoft\ConsoleIo\Output\CliOutput;
use Adachsoft\ConsoleIo\Output\ColoredCliOutput;
use Adachsoft\ConsoleIo\Output\OutputInterface;

$host = '127.0.0.1';
$port = 2160;
$bufferSize = 1048576;
$colorsEnabled = false;

foreach (array_slice($argv, 1) as $arg) {
    if ($arg === '--help' || $arg === '-h') {
        $output = new CliOutput();
        $output->writeLine('Simple TCP log server');
        $output->writeLine('');
        $output->writeLine('Usage:');
        $output->writeLine('  php bin/server.php [--host=127.0.0.1] [--port=2160] [--buffer_size=1048576] [--colors=0|1]');

        exit(0);
    }

    if (str_starts_with($arg, '--host=')) {
        $host = substr($arg, strlen('--host='));

        continue;
    }

    if (str_starts_with($arg, '--port=')) {
        $portValue = substr($arg, strlen('--port='));
        $parsedPort = filter_var($portValue, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 65535]]);

        if ($parsedPort === false) {
            (new CliOutput())->writeErrorLine('Invalid port value.');

            exit(2);
        }

        $port = (int) $parsedPort;

        continue;
    }

    if (str_starts_with($arg, '--buffer_size=')) {
        $bufferSizeValue = substr($arg, strlen('--buffer_size='));
        $parsedBufferSize = filter_var($bufferSizeValue, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 268435456]]);

        if ($parsedBufferSize === false) {
            (new CliOutput())->writeErrorLine('Invalid buffer_size value.');

            exit(2);
        }

        $bufferSize = (int) $parsedBufferSize;

        continue;
    }

    if ($arg === '--colors=1') {
        $colorsEnabled = true;

        continue;
    }

    if ($arg === '--colors=0') {
        $colorsEnabled = false;

        continue;
    }
}

$output = new CliOutput();

if ($colorsEnabled) {
    $output = new ColoredCliOutput($output);
}

$address = sprintf('tcp://%s:%d', $host, $port);

$server = @stream_socket_server($address, $errno, $errstr);

if ($server === false) {
    $output->writeErrorLine(sprintf('Cannot start server on %s: %s (%d)', $address, $errstr, $errno));

    exit(1);
}

stream_set_blocking($server, true);

$output->writeLine(sprintf('Listening on %s', $address));

while (true) {
    $client = @stream_socket_accept($server, -1);

    if ($client === false) {
        continue;
    }

    while (!feof($client)) {
        $data = fread($client, $bufferSize);

        if ($data === '' || $data === false) {
            break;
        }

        $output->write($data);
    }

    fclose($client);
}
