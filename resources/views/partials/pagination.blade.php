@if ($paginator->hasPages())
    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
        <ul class="pagination-list m-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="pagination-previous is-disabled" aria-disabled="true">
                    @lang('Prev')
                </li>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-previous"
                    rel="prev">@lang('Prev')</a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next" rel="next">@lang('Next')</a>
            @else
                <li class="pagination-next is-disabled" aria-disabled="true">
                    @lang('Next')
                </li>
            @endif
        </ul>
    </nav>
@endif
