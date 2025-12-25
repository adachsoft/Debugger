# adachsoft/debugger

A small, framework-agnostic PHP debugger/logger that can dump variables, print backtraces and measure execution time.

It can be used directly by instantiating `AdachSoft\Debugger\Debugger` with your preferred `LogInterface` and `ParserInterface`, or via the global facade `D` / helper function `d()`.

## Requirements

- PHP ^8.3

## Installation

```bash
composer require adachsoft/debugger
```

## Quick start (explicit instance)

```php
use AdachSoft\Debugger\Debugger;
use AdachSoft\Debugger\Log\LogPrint;
use AdachSoft\Debugger\ParserVarDump;

$debugger = new Debugger(new LogPrint(), new ParserVarDump());

$debugger->varDump(['hello' => 'world']);
$debugger->backTrace();
```

## Quick start (factory)

The factory provides ready-to-use presets:

```php
use AdachSoft\Debugger\DebuggerFactory;

$debugger = DebuggerFactory::create();
$debugger->varDump('hello');
```

Available presets:

- `DebuggerFactory::create()`
- `DebuggerFactory::createColored()`
- `DebuggerFactory::createTypeWithoutValue()`

## Global facade (D) and helper function (d)

This package ships a global class `D` (in the global namespace) and a global helper function `d()`.
They are autoloaded through Composer `autoload.files`, so they work after including `vendor/autoload.php`.

```php
require_once __DIR__ . '/vendor/autoload.php';

d(['a' => 1, 'b' => [true, null]]);

D::useTypeOnly();
d(['a' => 1, 'b' => [true, null]]);

D::useStandard();
D::dump('standard mode', ['x' => 123]);
```

## Timing

```php
D::start();
usleep(100_000);
$elapsed = D::stop('sleep');

D::dump('elapsed', $elapsed);
```

## Backtrace

```php
D::trace();
```

## Error handler

```php
use AdachSoft\Debugger\Debugger;

Debugger::showAllErrors();

$debugger = D::getInstance();
$debugger->setErrorHandler();

// Any PHP warning/notice/error will be formatted and sent to the configured logger.
```

## Logging targets

The debugger delegates output to a `LogInterface` implementation.

Built-in loggers (see `src/Log`):

- `AdachSoft\Debugger\Log\LogPrint` (console output)
- `AdachSoft\Debugger\Log\LogToFile` (append to a file)
- `AdachSoft\Debugger\Log\LogToServer` (send to a TCP server)

Example:

```php
use AdachSoft\Debugger\Debugger;
use AdachSoft\Debugger\Log\LogToFile;
use AdachSoft\Debugger\ParserVarDump;

$debugger = new Debugger(
    new LogToFile(fileName: __DIR__ . '/debug.log'),
    new ParserVarDump(),
);

$debugger->varDump('saved to file');
```

## License

MIT
