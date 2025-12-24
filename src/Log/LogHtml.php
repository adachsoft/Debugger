<?php

declare(strict_types=1);

namespace AdachSoft\Debugger\Log;

class LogHtml implements LogInterface
{
    /**
     * {@inheritDoc}
     */
    public function log(string $message): void
    {
        $safeMessage = htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        echo "<pre>{$safeMessage}</pre>";
    }
}
