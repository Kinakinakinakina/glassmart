{{-- Hand-written paginator (no SVG icons) — the default Laravel view ships
     Tailwind-sized SVG chevrons, which balloon once Tailwind is removed. --}}
@if ($paginator->hasPages())
    <nav class="aero-pagination" role="navigation" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="aero-btn aero-btn--sm aero-btn--disabled">&larr; Prev</span>
        @else
            <a class="aero-btn aero-btn--sm" href="{{ $paginator->previousPageUrl() }}" rel="prev">&larr; Prev</a>
        @endif

        <span class="aero-page-info">
            Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
        </span>

        @if ($paginator->hasMorePages())
            <a class="aero-btn aero-btn--sm" href="{{ $paginator->nextPageUrl() }}" rel="next">Next &rarr;</a>
        @else
            <span class="aero-btn aero-btn--sm aero-btn--disabled">Next &rarr;</span>
        @endif
    </nav>
@endif
