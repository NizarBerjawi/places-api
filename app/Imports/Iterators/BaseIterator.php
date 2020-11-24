<?php

namespace App\Imports\Iterators;

use App\Imports\Concerns\GeonamesIterable;
use App\Imports\Traits\Sanitizable;
use Illuminate\Support\LazyCollection;

class BaseIterator implements GeonamesIterable
{
    use Sanitizable;
    
    /**
     * The path of the file to be read
     *
     * @param string
     */
    public $filepath;

    /**
     * The delimiter used in the file
     *
     * @var string
     */
    public $delimiter;

    /**
     * Initialize an instance
     *
     * @param string $filepath
     * @param string $delimiter
     */
    public function __construct(string $filepath, string $delimiter = "\t")
    {
        $this->filepath = $filepath;
        $this->delimiter = $delimiter;
    }

    /**
     * Decides whether to skip a row or not
     *
     * @param array  $row
     * @return boolean
     */
    public function skip(array $row)
    {
        return false;
    }

    /**
     * Iterates over the file and returns a LazyCollection which
     * yields the values on every line
     *
     * @return \Illuminate\Support\LazyCollection
     */
    public function iterable()
    {
        return LazyCollection::make(function () {
            $handle = fopen($this->filepath, 'r');

            try {
                while (($line = fgets($handle)) !== false) {
                    $data = $this->clean(
                        explode($this->delimiter, $line)
                    );
                    
                    if ($this->skip($data)) {
                        continue;
                    }

                    yield $data;
                }
            } finally {
                fclose($handle);
            }
        });
    }
}
