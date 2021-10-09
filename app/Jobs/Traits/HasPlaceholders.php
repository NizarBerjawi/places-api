<?php

namespace App\Jobs\Traits;

trait HasPlaceholders
{
    /**
     * Parse a string and return an array of all the
     * placeholders available in it.
     *
     * @param string $text
     * @return array
     */
    public function parse(string $text)
    {
        $placeholders = [];

        while ($text) {
            $start = strpos($text, '<<');

            if ($start == false) {
                break;
            }

            $text = substr($text, $start + 2);

            $end = strpos($text, '>>');

            $placeholder = substr($text, 0, $end);

            $placeholders[] = $placeholder;
        }

        return array_unique($placeholders);
    }

    /**
     * Replace a placeholder with a value.
     *
     * @param string $placeholder
     * @param string $value
     * @param string $string
     * @return mixed
     */
    public function replace(string $placeholder, string $value, string $string)
    {
        $placeholders = $this->parse($string);

        if (! in_array($placeholder, $placeholders)) {
            return false;
        }

        return str_replace("<<$placeholder>>", $value, $string);
    }
}
