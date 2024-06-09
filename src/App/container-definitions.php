<?php

declare(strict_types=1);

use Framework\TemplateEngine;
use App\Config\Paths;

// Factory function
// Where is my mind?
return [
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEW)
];
