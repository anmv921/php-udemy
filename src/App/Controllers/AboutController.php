<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class AboutController
{



    // Container.php loads the view if I understand it correctly
    public function __construct(
        private TemplateEngine $view
    ) {
    }

    public function about()
    {

        echo $this->view->render(
            "/about.php",
            [
                'title' => 'About'
            ]
        );
    }
}
