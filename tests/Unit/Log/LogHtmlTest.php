<?php

declare(strict_types=1);

namespace Tests\Unit\Log;

use AdachSoft\Debugger\Log\LogHtml;
use AdachSoft\Debugger\Log\LogInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tests\Shared\ConsoleIo\TestDouble\SpyOutput;

#[CoversClass(LogHtml::class)]
final class LogHtmlTest extends TestCase
{
    public function testItImplementsLogInterface(): void
    {
        // Arrange
        $sut = new LogHtml();

        // Act
        $result = $sut;

        // Assert
        self::assertInstanceOf(LogInterface::class, $result);
    }

    public function testLogEscapesAndFormatsHtml(): void
    {
        // Arrange
        $output = new SpyOutput();
        $sut = new LogHtml($output);

        // Act
        $sut->log('<script>alert("xss")</script>');

        // Assert
        self::assertSame('<pre>&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;</pre>', $output->getOutput());
    }
}
