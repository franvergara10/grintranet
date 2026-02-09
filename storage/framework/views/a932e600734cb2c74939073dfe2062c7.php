

<?php $__env->startSection('title', 'Crear Rol'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Crear Rol</h1>
    <a href="<?php echo e(route('roles.index')); ?>" class="btn" style="background: rgba(255, 255, 255, 0.1);">Volver</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="<?php echo e(route('roles.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        
        <div class="form-group">
            <label for="name">Nombre del Rol</label>
            <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required placeholder="Ej: editor, moderador...">
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
            <label style="margin-bottom: 1rem;">Permisos</label>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.5rem; background: rgba(0,0,0,0.1); padding: 1rem; border-radius: 0.5rem;">
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="permissions[]" value="<?php echo e($permission->name); ?>" style="width: auto;">
                        <span><?php echo e($permission->name); ?></span>
                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Guardar Rol</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\grintranet\usuarios_v4\usuarios\resources\views/roles/create.blade.php ENDPATH**/ ?>