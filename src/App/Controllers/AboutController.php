<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class AboutController
{

    public function __construct(private TemplateEngine $aboutView)
    {
    }

    public function aboutPage()
    {
        echo $this->aboutView->render(
            "/aboutTemplate.php",
            [
                'title' => 'About',
                'dangerousData' => '<script>alert(123)</script>'
            ]
        );
    }
}
