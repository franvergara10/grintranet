

<?php $__env->startSection('title', 'Lista de Clase - ' . $group->course . ' ' . $group->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title"><?php echo e($group->course); ?> - <?php echo e($group->name); ?></h1>
            <p style="color: var(--text-muted);">
                Tutor:
                <?php if($group->tutor): ?>
                    <strong style="color: #fff;"><?php echo e($group->tutor->name); ?> <?php echo e($group->tutor->last_name); ?></strong>
                <?php else: ?>
                    <span style="font-style: italic;">Sin asignar</span>
                <?php endif; ?>
            </p>
        </div>
        <a href="<?php echo e(route('groups.index')); ?>" class="btn" style="background: rgba(255, 255, 255, 0.1);">Volver al
            listado</a>
    </div>

    <div class="card table-container">
        <h2 style="margin-bottom: 1.5rem; font-size: 1.25rem;">Listado de Alumnos (<?php echo e($group->students->count()); ?>)</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Fecha Alta</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $group->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="font-weight: 500;"><?php echo e($student->name); ?></td>
                        <td><?php echo e($student->last_name); ?></td>
                        <td style="color: var(--text-muted);"><?php echo e($student->email); ?></td>
                        <td style="color: var(--text-muted);"><?php echo e($student->created_at->format('d/m/Y')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">No hay alumnos
                            asignados a este grupo.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\grintranet\resources\views/groups/show.blade.php ENDPATH**/ ?>