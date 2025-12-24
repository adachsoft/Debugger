<?php

declare(strict_types=1);

namespace Tests\Unit\Log;

use AdachSoft\Debugger\Log\LogHtml;
use AdachSoft\Debugger\Log\LogInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

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
        $this->assertInstanceOf(LogInterface::class, $result);
    }

    public function testLogEscapesAndFormatsHtml(): void
    {
        // Arrange
        $sut = new LogHtml();
        $this->expectOutputString('<pre>&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;</pre>');

        // Act
        $sut->log('<script>alert("xss")</script>');

        // Assert
        // Assertions are performed by expectOutputString().
    }
}
