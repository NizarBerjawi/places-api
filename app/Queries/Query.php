<?php

namespace App\Queries;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Arr;
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
     */
    abstract public function modelClass(): string;

    /**
     * The attributes we can use to filter.
     */
    abstract public function getAllowedFilters(): array;

    /**
     * The relations that we can include.
     */
    abstract public function getAllowedIncludes(): array;

    /**
     * The allowed fields to sort by.
     */
    abstract public function getAllowedSorts(): array;

    /**
     * Apply a scope to the builder.
     *
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
     * @return $this
     */
    public function apply(callable $callable): self
    {
        $callable($this->builder);

        return $this;
    }

    /**
     * The query builder used to apply the filters.
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
     *
     *     @OA\Schema(
     *         type="object",
     *
     *         @OA\Property(
     *             property="cursor",
     *             type="object",
     *             description="The cursor is an encoded string containing the location that the next paginated query should start paginating and the direction that it should paginate.",
     *             @OA\Property(
     *                  property="eq",
     *                  type="string"
     *             ),
     *         ),
     *         @OA\Property(
     *             property="size",
     *             type="object",
     *             description="The size is an integer that determines the number of results to return per page.",
     *             @OA\Property(
     *                  property="eq",
     *                  type="integer"
     *             ),
     *         ),
     *     )
     * )
     *
     * @return \Illuminate\Pagination\CursorPaginator
     */
    public function getPaginator(): CursorPaginator
    {
        $this->checkBuilder();

        $defaultSize = config('paginate.default_size');
        $maxResults = config('paginate.max_results');

        $size = (int) request()->input('page.size.eq', $defaultSize);

        if ($size <= 0) {
            $size = $defaultSize;
        }

        if ($size > $maxResults) {
            $size = $maxResults;
        }

        $cursor = (string) request()->input('page.cursor.eq');

        return $this->getBuilder()
            ->cursorPaginate($size, ['*'], 'page[cursor][eq]', $cursor)
            ->appends(Arr::except(request()->input(), 'page.cursor.eq'));
    }

    /**
     * Initialize the query builder.
     */
    protected function initializeBuilder(): void
    {
        $this->builder = QueryBuilder::for($this->modelClass());

        $this->isInitialized = $this->builder instanceof QueryBuilder;
    }

    /**
     * Check if the builder has been initialized.
     */
    protected function checkBuilder(): void
    {
        if (! $this->isInitialized) {
            throw new \Exception('Query not initialized');
        }
    }
}
