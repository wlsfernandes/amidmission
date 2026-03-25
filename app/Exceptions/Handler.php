<?php

use App\Services\SystemLogger;

$this->reportable(function (\Throwable $e) {
    SystemLogger::log(
        'Unhandled exception',
        'critical',
        request()->route()?->getName(),
        [
            'exception' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]
    );
});