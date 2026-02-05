<?php $__env->startSection('title', 'Gestión de Zonas'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1 class="page-title">Zonas</h1>
        <a href="<?php echo e(route('zonas.create')); ?>" class="btn btn-primary">Nueva Zona</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert"
            style="background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Search and Filter Bar -->
    <div class="card" style="padding: 1.5rem; margin-bottom: 2rem;">
        <form action="<?php echo e(route('zonas.index')); ?>" method="GET" style="display: flex; gap: 1rem; align-items: center;">
            <!-- Preserve sort params -->
            <?php if(request('sort_by')): ?> <input type="hidden" name="sort_by" value="<?php echo e(request('sort_by')); ?>"> <?php endif; ?>
            <?php if(request('sort_order')): ?> <input type="hidden" name="sort_order" value="<?php echo e(request('sort_order')); ?>"> <?php endif; ?>

            <div style="flex: 2;">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Buscar por nombre o planta..."
                    style="width: 100%;">
            </div>

            <button type="submit" class="btn btn-primary">Buscar</button>
            <?php if(request('search')): ?>
                <a href="<?php echo e(route('zonas.index')); ?>" class="btn" style="background: rgba(255, 255, 255, 0.1);">Limpiar</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card table-container">
        <table>
            <thead>
                <tr>
                    <th><?php if (isset($component)) { $__componentOriginal1d8b735deae54f44d57c1992e3ef0e16 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sort-header','data' => ['column' => 'nombre','label' => 'Nombre','route' => 'zonas.index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sort-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'nombre','label' => 'Nombre','route' => 'zonas.index']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16)): ?>
<?php $attributes = $__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16; ?>
<?php unset($__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1d8b735deae54f44d57c1992e3ef0e16)): ?>
<?php $component = $__componentOriginal1d8b735deae54f44d57c1992e3ef0e16; ?>
<?php unset($__componentOriginal1d8b735deae54f44d57c1992e3ef0e16); ?>
<?php endif; ?></th>
                    <th><?php if (isset($component)) { $__componentOriginal1d8b735deae54f44d57c1992e3ef0e16 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sort-header','data' => ['column' => 'planta','label' => 'Planta','route' => 'zonas.index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sort-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'planta','label' => 'Planta','route' => 'zonas.index']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16)): ?>
<?php $attributes = $__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16; ?>
<?php unset($__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1d8b735deae54f44d57c1992e3ef0e16)): ?>
<?php $component = $__componentOriginal1d8b735deae54f44d57c1992e3ef0e16; ?>
<?php unset($__componentOriginal1d8b735deae54f44d57c1992e3ef0e16); ?>
<?php endif; ?></th>
                    <th><?php if (isset($component)) { $__componentOriginal1d8b735deae54f44d57c1992e3ef0e16 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sort-header','data' => ['column' => 'created_at','label' => 'Fecha Creación','route' => 'zonas.index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sort-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'created_at','label' => 'Fecha Creación','route' => 'zonas.index']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16)): ?>
<?php $attributes = $__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16; ?>
<?php unset($__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1d8b735deae54f44d57c1992e3ef0e16)): ?>
<?php $component = $__componentOriginal1d8b735deae54f44d57c1992e3ef0e16; ?>
<?php unset($__componentOriginal1d8b735deae54f44d57c1992e3ef0e16); ?>
<?php endif; ?></th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="font-weight: 500;"><?php echo e($zona->nombre); ?></td>
                        <td style="color: var(--text-muted);"><?php echo e($zona->planta); ?></td>
                        <td style="color: var(--text-muted);"><?php echo e($zona->created_at->format('d/m/Y')); ?></td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="<?php echo e(route('zonas.edit', $zona)); ?>" class="btn"
                                    style="background: rgba(255, 255, 255, 0.1); padding: 0.4rem 0.8rem; font-size: 0.8rem;">Editar</a>
                                <form action="<?php echo e(route('zonas.destroy', $zona)); ?>" method="POST"
                                    onsubmit="return confirm('¿Estás seguro?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger"
                                        style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div style="margin-top: 1rem;">
            <?php echo e($zonas->appends(request()->query())->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mgonpor116\Desktop\grintranet\resources\views/zonas/index.blade.php ENDPATH**/ ?>