@props(['column', 'label', 'route'])
@php
    $currentSortBy = request('sort_by');
    $currentSortOrder = request('sort_order', 'asc');
    $nextSortOrder = ($currentSortBy === $column && $currentSortOrder === 'asc') ? 'desc' : 'asc';
    $isActive = $currentSortBy === $column;
@endphp

<a href="{{ route($route, array_merge(request()->query(), ['sort_by' => $column, 'sort_order' => $nextSortOrder])) }}" 
   style="display: flex; align-items: center; gap: 0.25rem; color: inherit; text-decoration: none; cursor: pointer; user-select: none;">
    {{ $label }}
    <span style="display: inline-flex; flex-direction: column; font-size: 0.6rem; opacity: {{ $isActive ? 1 : 0.3 }};">
        @if($isActive && $currentSortOrder === 'desc')
            <span>▼</span>
        @elseif($isActive && $currentSortOrder === 'asc')
            <span>▲</span>
        @else
            <span>▲</span>
            <span style="margin-top: -4px;">▼</span>
        @endif
    </span>
</a>
