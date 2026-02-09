<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['column', 'label', 'route']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['column', 'label', 'route']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $currentSortBy = request('sort_by');
    $currentSortOrder = request('sort_order', 'asc');
    $nextSortOrder = ($currentSortBy === $column && $currentSortOrder === 'asc') ? 'desc' : 'asc';
    $isActive = $currentSortBy === $column;
?>

<a href="<?php echo e(route($route, array_merge(request()->query(), ['sort_by' => $column, 'sort_order' => $nextSortOrder]))); ?>" 
   style="display: flex; align-items: center; gap: 0.25rem; color: inherit; text-decoration: none; cursor: pointer; user-select: none;">
    <?php echo e($label); ?>

    <span style="display: inline-flex; flex-direction: column; font-size: 0.6rem; opacity: <?php echo e($isActive ? 1 : 0.3); ?>;">
        <?php if($isActive && $currentSortOrder === 'desc'): ?>
            <span>▼</span>
        <?php elseif($isActive && $currentSortOrder === 'asc'): ?>
            <span>▲</span>
        <?php else: ?>
            <span>▲</span>
            <span style="margin-top: -4px;">▼</span>
        <?php endif; ?>
    </span>
</a>
<?php /**PATH C:\laragon\www\grintranet\resources\views/components/sort-header.blade.php ENDPATH**/ ?>