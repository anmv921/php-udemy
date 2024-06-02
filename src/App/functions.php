<?php

declare(strict_types=1);

// Variable dump - die
function dd(mixed $in_value) {
    echo "<pre>";
    print_r($in_value);
    echo "</pre>";
    die();
}