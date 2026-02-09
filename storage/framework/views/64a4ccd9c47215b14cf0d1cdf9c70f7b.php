

<?php $__env->startSection('title', 'Gestión de Usuarios'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1 class="page-title">Usuarios</h1>
        <div style="display: flex; gap: 1rem;">
            <a href="<?php echo e(route('users.import')); ?>" class="btn"
                style="background: rgba(56, 189, 248, 0.1); color: var(--primary); border: 1px solid rgba(56, 189, 248, 0.2);">Importación
                Masiva</a>
            <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">Nuevo Usuario</a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert"
            style="background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Search and Filter Bar -->
    <div class="card" style="padding: 1.5rem; margin-bottom: 2rem;">
        <form action="<?php echo e(route('users.index')); ?>" method="GET" style="display: flex; gap: 1rem; align-items: center;">
            <!-- Preserve sort params -->
            <?php if(request('sort_by')): ?> <input type="hidden" name="sort_by" value="<?php echo e(request('sort_by')); ?>"> <?php endif; ?>
            <?php if(request('sort_order')): ?> <input type="hidden" name="sort_order" value="<?php echo e(request('sort_order')); ?>"> <?php endif; ?>

            <div style="flex: 2;">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Buscar por nombre o email..."
                    style="width: 100%;">
            </div>

            <div style="flex: 1;">
                <select name="group_id" style="width: 100%;" onchange="this.form.submit()">
                    <option value="">Cualquier Grupo</option>
                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($group->id); ?>" <?php echo e(request('group_id') == $group->id ? 'selected' : ''); ?>>
                            <?php echo e($group->course); ?> - <?php echo e($group->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div style="flex: 1;">
                <select name="role" style="width: 100%;" onchange="this.form.submit()">
                    <option value="">Todos los roles</option>
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($role->name); ?>" <?php echo e(request('role') == $role->name ? 'selected' : ''); ?>>
                            <?php echo e($role->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Filtrar</button>
            <?php if(request('search') || request('role') || request('course') || request('group')): ?>
                <a href="<?php echo e(route('users.index')); ?>" class="btn" style="background: rgba(255, 255, 255, 0.1);">Limpiar</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;"></th>
                    <th><?php if (isset($component)) { $__componentOriginal1d8b735deae54f44d57c1992e3ef0e16 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sort-header','data' => ['column' => 'name','label' => 'Nombre','route' => 'users.index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sort-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'name','label' => 'Nombre','route' => 'users.index']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sort-header','data' => ['column' => 'last_name','label' => 'Apellidos','route' => 'users.index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sort-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'last_name','label' => 'Apellidos','route' => 'users.index']); ?>
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
                    <th>Grupo / Curso</th>
                    <th><?php if (isset($component)) { $__componentOriginal1d8b735deae54f44d57c1992e3ef0e16 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sort-header','data' => ['column' => 'email','label' => 'Email','route' => 'users.index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sort-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'email','label' => 'Email','route' => 'users.index']); ?>
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
                    <th>Roles</th>
                    <th><?php if (isset($component)) { $__componentOriginal1d8b735deae54f44d57c1992e3ef0e16 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d8b735deae54f44d57c1992e3ef0e16 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sort-header','data' => ['column' => 'created_at','label' => 'Fecha Creación','route' => 'users.index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sort-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'created_at','label' => 'Fecha Creación','route' => 'users.index']); ?>
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
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php if($user->avatar): ?>
                                <img src="<?php echo e(asset('storage/' . $user->avatar)); ?>" alt="Avatar" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                            <?php else: ?>
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.8rem;">
                                    <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight: 500;"><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->last_name); ?></td>
                        <td style="color: var(--primary); font-weight: 500;">
                            <?php if($user->groupRel): ?>
                                <?php echo e($user->groupRel->course); ?> - <?php echo e($user->groupRel->name); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td style="color: var(--text-muted);"><?php echo e($user->email); ?></td>
                        <td>
                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge badge-role"><?php echo e($role->name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td style="color: var(--text-muted);"><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn"
                                    style="background: rgba(255, 255, 255, 0.1); padding: 0.4rem 0.8rem; font-size: 0.8rem;">Editar</a>
                                <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST"
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
            <?php echo e($users->appends(request()->query())->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\grintranet\usuarios_v4\usuarios\resources\views/users/index.blade.php ENDPATH**/ ?>