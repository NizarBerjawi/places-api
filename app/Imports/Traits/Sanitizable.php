<?php

namespace App\Imports\Traits;

trait Sanitizable
{
    /**
     * Cleans/Sanitises an array of strings.
     *
     * @param  array  $row
     * @return array
     */
    public function clean(array $row)
    {
        return array_map(function ($item) {
            $item = $this->removeUtf8Bom($item);
            $item = $this->removeEmptyStrings($item);

            if (is_string($item)) {
                $item = $this->trim($item);
            }

            return $item;
        }, $row);
    }

    /**
     * Removes any UTF8 BOM characters from a given string.
     *
     * @param  string  $text
     * @return string
     */
    protected function removeUtf8Bom($text)
    {
        $bom = pack('H*', 'EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);

        return $text;
    }

    /**
     * Replace empty strings with null values.
     *
     * @param  string  $text
     * @return mixed
     */
    protected function removeEmptyStrings(string $text)
    {
        return $text !== '' ? $text : null;
    }

    /**
     * Trim any trailing spaces at start or end of a string.
     *
     * @param  string  $text
     * @return string $text
     */
    protected function trim(string $text)
    {
        if (empty($text)) {
            return $text;
        }

        return trim($text);
    }
}
