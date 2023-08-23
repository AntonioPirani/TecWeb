@php
 use Illuminate\Pagination\LengthAwarePaginator;

$collection = \App\Models\Resources\Auto::all();
$perPage = 5;

$currentPage = LengthAwarePaginator::resolveCurrentPage();
$items = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

$paginator = new LengthAwarePaginator($items, $collection->count(), $perPage);

@endphp
@if ($paginator->lastPage() != 1)
<div id="pagination">
    {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} di {{ $paginator->total() }} ---

    <!-- Link alla prima pagina -->
    @if (!$paginator->onFirstPage())
        <a href="{{ $paginator->url(1) }}">Inizio</a> |
    @else
        Inizio |
    @endif

    <!-- Link alla pagina precedente -->
    @if ($paginator->currentPage() != 1)
        <a href="{{ $paginator->previousPageUrl() }}">&lt; Precedente</a> |
    @else
        &lt; Precedente |
    @endif

    <!-- Link alla pagina successiva -->
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}">Successivo &gt;</a> |
    @else
        Successivo &gt; |
    @endif

    <!-- Link all'ultima pagina -->
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->url($paginator->lastPage()) }}">Fine</a>
    @else
        Fine
    @endif
</div>
@endif
