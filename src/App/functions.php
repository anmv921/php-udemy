<?php

declare(strict_types=1);

// Variable dump - die
function dd(mixed $in_value)
{
    echo "<pre>";
    print_r($in_value);
    echo "</pre>";
    die();
}

// Short for escape
function e(mixed $value): string
{
    // This functions converts html tags into text
    // in order to avoid script injection, for example
    return htmlspecialchars((string) $value);
}

function redirectTo(string $path)
{
    header("Location: {$path}");

    // 302 Found
    http_response_code(302);

    exit;
}
