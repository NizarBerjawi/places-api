@if ($paginator->hasPages())
<nav class="pagination is-centered" role="navigation" aria-label="pagination">
        <ul class="pagination-list m-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="pagination-previous is-disabled" aria-disabled="true">
                    <span>@lang('Prev')</span>
                </li>
            @else
                <li class="pagination-previous">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('Prev')</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="pagination-next">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('Next')</a>
                </li>
            @else
                <li class="pagination-next is-disabled" aria-disabled="true">
                    <span>@lang('Next')</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
