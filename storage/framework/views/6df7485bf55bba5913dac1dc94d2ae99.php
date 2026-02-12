

<?php $__env->startSection('title', 'Gestión de Grupos - Gestor de Usuarios'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1 class="page-title"><?php echo e(auth()->user()->hasRole('admin') ? 'Cursos y Grupos' : 'Mis Grupos'); ?></h1>
        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
        <a href="<?php echo e(route('groups.create')); ?>" class="btn btn-primary">Nuevo Grupo</a>
        <?php endif; ?>
    </div>

    <?php if(session('success')): ?>
        <div class="alert"
            style="background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="card table-container">
        <table>
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Grupo</th>
                    <th>Tutor</th>
                    <th>Alumnos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="font-weight: 500; color: var(--primary);"><?php echo e($group->course); ?></td>
                        <td style="font-weight: 600;"><?php echo e($group->name); ?></td>
                        <td>
                            <?php if($group->tutor): ?>
                                <span style="color: #fff;"><?php echo e($group->tutor->name); ?> <?php echo e($group->tutor->last_name); ?></span>
                            <?php else: ?>
                                <span style="color: var(--text-muted); font-style: italic;">Sin tutor</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge badge-role"><?php echo e($group->students_count); ?></span>
                        </td>
                        <td style="display: flex; gap: 0.5rem;">
                            <a href="<?php echo e(route('groups.show', $group)); ?>" class="btn"
                                style="background: rgba(56, 189, 248, 0.1); color: var(--primary); padding: 0.4rem 0.8rem; font-size: 0.8rem;">Ver
                                Alumnos</a>
                            <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                            <a href="<?php echo e(route('groups.edit', $group)); ?>" class="btn"
                                style="background: rgba(255, 255, 255, 0.1); padding: 0.4rem 0.8rem; font-size: 0.8rem;">Editar</a>
                            <form action="<?php echo e(route('groups.destroy', $group)); ?>" method="POST"
                                onsubmit="return confirm('¿Estás seguro?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger"
                                    style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Eliminar</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 2rem;">No hay grupos
                            creados aún.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\grintranet\resources\views/groups/index.blade.php ENDPATH**/ ?>