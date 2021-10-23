<?php

namespace App\Queries;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

abstract class Query
{
    /**
     * An instance of the query builder.
     *
     * @var \Spatie\QueryBuilder\QueryBuilder
     */
    protected $builder;

    /**
     * A flag to determine if the query builder has been
     * initialized.
     *
     * @var bool
     */
    protected $isInitialized;

    /**
     * Instantiate the Query.
     *
     * @return void
     */
    public function __construct()
    {
        $this->initializeBuilder();
    }

    /**
     * Return the model classname to be filtered.
     *
     * @return string
     */
    abstract public function modelClass(): string;

    /**
     * The attributes we can use to filter.
     *
     * @return array
     */
    abstract public function getAllowedFilters(): array;

    /**
     * The relations that we can include.
     *
     * @return array
     */
    abstract public function getAllowedIncludes(): array;

    /**
     * The allowed fields to sort by.
     *
     * @return array
     */
    abstract public function getAllowedSorts(): array;

    /**
     * Apply a scope to the builder.
     *
     * @param string $scope
     * @param array $parameters
     * @return static
     */
    public function applyScope(string $scope, array $parameters = []): self
    {
        $this->builder->scopes([$scope => $parameters]);

        return $this;
    }

    /**
     * Append more expressions to the Builder.
     *
     * @param callable $callable
     * @return $this
     */
    public function apply(callable $callable): self
    {
        $callable($this->builder);

        return $this;
    }

    /**
     * The query builder used to apply the filters.
     *
     * @return \Spatie\QueryBuilder\QueryBuilder
     */
    public function getBuilder(): QueryBuilder
    {
        $this->checkBuilder();

        $class = $this->modelClass();

        return $this->builder
            ->allowedFilters($this->getAllowedFilters())
            ->allowedIncludes($this->getAllowedIncludes())
            ->defaultSort((new $class)->getKeyName())
            ->allowedSorts($this->getAllowedSorts());
    }

    /**
     * The paginator used to paginate the result.
     *
     * @OA\Parameter(
     *     parameter="pagination",
     *     name="page",
     *     in="query",
     *     description="Paginate the data",
     *     required=false,
     *     style="deepObject",
     *     @OA\Schema(
     *         type="object",
     *         enum = {"number", "size"},
     *         @OA\Property(
     *             property="number",
     *             type="integer",
     *             example="1"
     *         ),
     *         @OA\Property(
     *             property="size",
     *             type="integer",
     *             example="10"
     *         ),
     *     )
     * )
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginator(): LengthAwarePaginator
    {
        $this->checkBuilder();

        return $this->getBuilder()->jsonPaginate();
    }

    /**
     * Initialize the query builder.
     *
     * @return void
     */
    protected function initializeBuilder(): void
    {
        $this->builder = QueryBuilder::for($this->modelClass());

        $this->isInitialized = $this->builder instanceof QueryBuilder;
    }

    /**
     * Check if the builder has been initialized.
     *
     * @return void
     */
    protected function checkBuilder(): void
    {
        if (! $this->isInitialized) {
            throw new \Exception('Query not initialized');
        }
    }
}
