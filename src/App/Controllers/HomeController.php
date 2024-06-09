<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class HomeController
{

    // Container.php loads the view if I understand it correctly
    public function __construct(private TemplateEngine $view)
    {
    }

    public function home()
    {
        echo $this->view->render(
            "/indexTemplate.php"
        );
    }
}
