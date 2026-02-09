

<?php $__env->startSection('title', 'Editar Grupo - Gestor de Usuarios'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1 class="page-title">Editar Grupo</h1>
        <a href="<?php echo e(route('groups.index')); ?>" class="btn" style="background: rgba(255, 255, 255, 0.1);">Volver</a>
    </div>

    <div class="card" style="max-width: 600px;">
        <form action="<?php echo e(route('groups.update', $group)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-group">
                <label for="course">Curso</label>
                <input type="text" name="course" id="course" value="<?php echo e(old('course', $group->course)); ?>" required
                    placeholder="Ej: ESO, Bachillerato, DAW...">
                <?php $__errorArgs = ['course'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color: var(--danger); font-size: 0.8rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="name">Nombre del Grupo</label>
                <input type="text" name="name" id="name" value="<?php echo e(old('name', $group->name)); ?>" required
                    placeholder="Ej: 1º A, 2º B...">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color: var(--danger); font-size: 0.8rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="tutor_id">Tutor Asignado</label>
                <select name="tutor_id" id="tutor_id">
                    <option value="">Sin tutor asignado</option>
                    <?php $__currentLoopData = $tutors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tutor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tutor->id); ?>" <?php echo e(old('tutor_id', $group->tutor_id) == $tutor->id ? 'selected' : ''); ?>>
                            <?php echo e($tutor->name); ?> <?php echo e($tutor->last_name); ?> (<?php echo e($tutor->email); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['tutor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color: var(--danger); font-size: 0.8rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">Actualizar Grupo</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\grintranet\usuarios_v4\usuarios\resources\views/groups/edit.blade.php ENDPATH**/ ?>