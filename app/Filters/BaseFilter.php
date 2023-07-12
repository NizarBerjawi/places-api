<?php

namespace App\Filters;

use App\Exceptions\InvalidOperatorQuery;
use App\Exceptions\NestedOperatorException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\Filters\Filter;

abstract class BaseFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $operations = Collection::make($this->allowedOperators())->keys();

        foreach (Arr::wrap($value) as $operator => $item) {
            $hasOperator = ! empty($operator);

            if ($hasOperator && $operations->doesntContain($operator)) {
                throw new InvalidOperatorQuery($operator, $operations, static::description());
            }

            $filters = Arr::wrap($item);

            if (Arr::isAssoc($filters)) {
                throw new NestedOperatorException();
            }

            $symbol = Arr::get($this->allowedOperators(), $operator, '=');

            foreach ($filters as $index => $value) {
                $query->where($property, $symbol, $value, $index === 0 ? 'and' : 'or');
            }
        }
    }

    abstract public function allowedOperators();

    abstract public static function description();
}
