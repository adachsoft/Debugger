#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Simple TCP log server.
 *
 * Equivalent of: ncat -lk 2160
 *
 * Usage:
 *   php bin/server.php [--host=127.0.0.1] [--port=2160] [--buffer_size=1048576]
 */

$host = '127.0.0.1';
$port = 2160;
$bufferSize = 1048576;

foreach (array_slice($argv, 1) as $arg) {
    if ($arg === '--help' || $arg === '-h') {
        fwrite(
            STDOUT,
            "Simple TCP log server\n\n" .
            "Usage:\n  php bin/server.php [--host=127.0.0.1] [--port=2160] [--buffer_size=1048576]\n"
        );

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
            fwrite(STDERR, "Invalid port value.\n");

            exit(2);
        }

        $port = (int) $parsedPort;

        continue;
    }

    if (str_starts_with($arg, '--buffer_size=')) {
        $bufferSizeValue = substr($arg, strlen('--buffer_size='));
        $parsedBufferSize = filter_var($bufferSizeValue, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 268435456]]);

        if ($parsedBufferSize === false) {
            fwrite(STDERR, "Invalid buffer_size value.\n");

            exit(2);
        }

        $bufferSize = (int) $parsedBufferSize;

        continue;
    }
}

$address = sprintf('tcp://%s:%d', $host, $port);

$server = @stream_socket_server($address, $errno, $errstr);

if ($server === false) {
    fwrite(STDERR, sprintf("Cannot start server on %s: %s (%d)\n", $address, $errstr, $errno));

    exit(1);
}

stream_set_blocking($server, true);

fwrite(STDOUT, sprintf("Listening on %s\n", $address));

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

        fwrite(STDOUT, $data);
        fflush(STDOUT);
    }

    fclose($client);
}
