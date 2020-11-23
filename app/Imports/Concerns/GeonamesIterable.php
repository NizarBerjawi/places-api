<?php

namespace App\Imports\Concerns;

interface GeonamesIterable
{
    /**
     * Decides whether to skip a row or not
     *
     * @param array  $row
     * @return boolean
     */
    public function skip(array $row);

    /**
     * Execute a callback over each item.
     *
     * @param  callable  $callback
     * @return $this
     */
    public function iterable();
}
