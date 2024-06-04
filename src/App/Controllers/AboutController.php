<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class AboutController
{
    private TemplateEngine $aboutView;

    public function __construct()
    {
        $this->aboutView = new TemplateEngine(Paths::VIEW);
    }

    public function aboutPage()
    {
        echo $this->aboutView->render(
            "/about.php",
            []
        );
    }
}
