<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    public function __construct(private string $basePath)
    {
    }

    public function render(string $template, array $data = [])
    {
        // Transforms array items into variables
        // In this case ['title' => 'Home page'] is turned
        // into a variable called $title with a value 'Home page'
        extract($data, EXTR_SKIP);
        include "{$this->basePath}/{$template}";

        // buffering
        ob_start();
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}
