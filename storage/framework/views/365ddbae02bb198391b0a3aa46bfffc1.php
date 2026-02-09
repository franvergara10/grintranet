

<?php $__env->startSection('title', 'Editar Usuario'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1 class="page-title">Editar Usuario</h1>
        <a href="<?php echo e(route('users.index')); ?>" class="btn" style="background: rgba(255, 255, 255, 0.1);">Volver</a>
    </div>

    <div class="card" style="max-width: 600px;">
        <form action="<?php echo e(route('users.update', $user)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" required>
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
                <label for="last_name">Apellidos</label>
                <input type="text" name="last_name" id="last_name" value="<?php echo e(old('last_name', $user->last_name)); ?>">
                <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color: var(--danger); font-size: 0.8rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color: var(--danger); font-size: 0.8rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group" id="student-only-fields" style="display: none;">
                <label for="group_id">Asignar a Grupo</label>
                <select name="group_id" id="group_id">
                    <option value="">Seleccionar Grupo</option>
                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($group->id); ?>" <?php echo e(old('group_id', $user->group_id) == $group->id ? 'selected' : ''); ?>>
                            <?php echo e($group->course); ?> - <?php echo e($group->name); ?> (Tutor: <?php echo e($group->tutor->name ?? 'Sin asignar'); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['group_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color: var(--danger); font-size: 0.8rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const roleSelect = document.getElementById('role');
                    const courseGroup = document.getElementById('course-group');

                    function toggleCourse() {
                        if (roleSelect.value === 'alumno') {
                            document.getElementById('student-only-fields').style.display = 'block';
                        } else {
                            document.getElementById('student-only-fields').style.display = 'none';
                        }
                    }

                    roleSelect.addEventListener('change', toggleCourse);
                    toggleCourse(); // Initial state
                });
            </script>

            <div class="form-group">
                <label for="role">Rol</label>
                <select name="role" id="role" required>
                    <option value="">Seleccionar Rol</option>
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($role->name); ?>" <?php echo e($user->hasRole($role->name) ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst($role->name)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color: var(--danger); font-size: 0.8rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group"
                style="padding: 1rem; border: 1px solid var(--border); border-radius: 0.5rem; background: rgba(0,0,0,0.1);">
                <label for="password" style="margin-bottom: 0;">Cambiar Contraseña (Opcional)</label>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">Deja en blanco para mantener la
                    actual.</p>

                <input type="password" name="password" id="password" placeholder="Nueva contraseña"
                    style="margin-bottom: 1rem;">

                <input type="password" name="password_confirmation" id="password_confirmation"
                    placeholder="Confirmar nueva contraseña">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color: var(--danger); font-size: 0.8rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\grintranet\usuarios_v4\usuarios\resources\views/users/edit.blade.php ENDPATH**/ ?>