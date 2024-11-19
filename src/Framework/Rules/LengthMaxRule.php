<?php

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class LengthMaxRule implements RuleInterface
{
  public function validate(array $data, string $field, array $params): bool
  {
        if( empty($params[0]) ) {
            throw new InvalidArgumentException("Max string length not specified");
        }

        $maxLength = (int) $params[0];

        return strlen($data[$field]) < $maxLength;
  }

  public function getMessage(array $data, string $field, array $params): string
  {
    return "Length of the text must be less than {$params[0]}";
  }
}