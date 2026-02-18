

<?php $__env->startSection('title', 'Nueva Zona'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1 class="page-title">Nueva Zona</h1>
        <a href="<?php echo e(route('zonas.index')); ?>" class="btn">Volver</a>
    </div>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <form action="<?php echo e(route('zonas.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="nombre" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    value="<?php echo e(old('nombre')); ?>" required>
                <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="planta" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Planta</label>
                <input type="text" name="planta" id="planta" class="form-control <?php $__errorArgs = ['planta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    value="<?php echo e(old('planta')); ?>" required>
                <?php $__errorArgs = ['planta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                <a href="<?php echo e(route('zonas.index')); ?>" class="btn" style="background: rgba(255, 255, 255, 0.1);">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\grintranet\resources\views/zonas/create.blade.php ENDPATH**/ ?>