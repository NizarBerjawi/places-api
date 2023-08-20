<?php

namespace App\Filters;

use App\Exceptions\InvalidOperatorQuery;
use App\Exceptions\NestedOperatorException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\Filters\Filter;

abstract class BaseFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $operations = Collection::make($this->allowedOperators())->keys();

        foreach (Arr::wrap($value) as $operator => $item) {
            $hasOperator = !empty($operator);

            if ($hasOperator && $operations->doesntContain($operator)) {
                throw new InvalidOperatorQuery($operator, $operations, static::description());
            }

            $filters = Arr::wrap($item);

            if (Arr::isAssoc($filters)) {
                throw new NestedOperatorException();
            }

            $symbol = Arr::get($this->allowedOperators(), $operator, '=');

            // If the "attribute" exists as a method on the model, we will just assume
            // it is a relationship
            if (method_exists($query->getModel(), Str::camel($property))) {
                return $query->whereHas(Str::camel($property), function (Builder $builder) use ($symbol, $filters) {
                    $key = $builder->getModel()->getKeyName();
                    $table = $builder->getModel()->getTable();

                    foreach ($filters as $index => $value) {
                        $builder->where("$table.$key", $symbol, $value, $index === 0 ? 'and' : 'or');
                    }
                });
            }
            
            foreach ($filters as $index => $value) {
                $query->where($property, $symbol, $value, $index === 0 ? 'and' : 'or');
            }
        }
    }

    abstract public function allowedOperators();

    abstract public static function description();
}
