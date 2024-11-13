<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    private array $globalTemplateData = [];

    public function __construct(private string $basePath)
    {
    }

    public function render(string $template, array $data = [])
    {

      
        // Transforms array items into variables
        // In this case ['title' => 'Home page'] is turned
        // into a variable called $title with a value 'Home page'
        extract($data, EXTR_SKIP);
        extract($this->globalTemplateData, EXTR_SKIP);

        include $this->resolve($template);

        // buffering
        ob_start();
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function resolve(string $path)
    {
        // die("{$this->basePath}/{$path}");
        return "{$this->basePath}/{$path}";

    }

    public function addGlobal(string $key, mixed $value)
    {
        $this->globalTemplateData[$key] = $value;
    }
}
