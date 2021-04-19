<?php

namespace App\Imports\Concerns;

interface GeonamesIterable
{
    /**
     * Execute a callback over each item.
     *
     * @return \Illuminate\Support\LazyCollection
     */
    public function iterable();
}
