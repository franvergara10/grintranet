

<?php $__env->startSection('title', 'Gestión de Roles'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Roles</h1>
    <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-primary">Nuevo Rol</a>
</div>

<?php if(session('success')): ?>
    <div class="alert" style="background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2);">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="alert alert-error">
        <?php echo e($errors->first()); ?>

    </div>
<?php endif; ?>

<!-- Search Bar -->
<div class="card" style="padding: 1.5rem; margin-bottom: 2rem;">
    <form action="<?php echo e(route('roles.index')); ?>" method="GET" style="display: flex; gap: 1rem;">
        <?php if(request('sort_by')): ?> <input type="hidden" name="sort_by" value="<?php echo e(request('sort_by')); ?>"> <?php endif; ?>
        <?php if(request('sort_order')): ?> <input type="hidden" name="sort_order" value="<?php echo e(request('sort_order')); ?>"> <?php endif; ?>
        
        <div style="flex: 1;">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Buscar por nombre..." style="width: 100%;">
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
        <?php if(request('search')): ?>
            <a href="<?php echo e(route('roles.index')); ?>" class="btn" style="background: rgba(255, 255, 255, 0.1);">Limpiar</a>
        <?php endif; ?>
    </form>
</div>

<div class="card table-container">
    <table>
        <thead>
            <tr>
                <th><?php if (isset($component)) { $__componentOriginal1d8b735deae54f44d57c1992e3ef0e16 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sort-header','data' => ['column' => 'name','label' => 'Nombre Rol','route' => 'roles.index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sort-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'name','label' => 'Nombre Rol','route' => 'roles.index']); ?>
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
                <th>Permisos</th>
                <th>Usuarios Asignados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="font-weight: 500;">
                    <span class="badge badge-role"><?php echo e(ucfirst($role->name)); ?></span>
                </td>
                <td>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.25rem;">
                        <?php $__empty_1 = true; $__currentLoopData = $role->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <span class="badge" style="background: rgba(255, 255, 255, 0.05); color: var(--text-muted); font-size: 0.7rem;"><?php echo e($permission->name); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <span style="color: var(--text-muted); font-size: 0.8rem;">Sin permisos</span>
                        <?php endif; ?>
                    </div>
                </td>
                <td style="color: var(--text-muted);">
                    <?php echo e($role->users()->count()); ?>

                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="<?php echo e(route('roles.edit', $role)); ?>" class="btn" style="background: rgba(255, 255, 255, 0.1); padding: 0.4rem 0.8rem; font-size: 0.8rem;">Editar</a>
                        
                        <?php if($role->name !== 'admin'): ?>
                            <form action="<?php echo e(route('roles.destroy', $role)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro? Esto quitará el rol a todos los usuarios que lo tengan.')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Eliminar</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
    <div style="margin-top: 1rem;">
        <?php echo e($roles->appends(request()->query())->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\usuarios\resources\views/roles/index.blade.php ENDPATH**/ ?>