@if ($paginator->hasPages())
    <nav class="pagination" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="btn btn-ghost btn-disabled" aria-disabled="true">&larr; Previous</span>
        @else
            <a class="btn btn-ghost" href="{{ $paginator->previousPageUrl() }}" rel="prev">&larr; Previous</a>
        @endif

        <span class="pagination-info">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a class="btn btn-ghost" href="{{ $paginator->nextPageUrl() }}" rel="next">Next &rarr;</a>
        @else
            <span class="btn btn-ghost btn-disabled" aria-disabled="true">Next &rarr;</span>
        @endif
    </nav>
@endif
