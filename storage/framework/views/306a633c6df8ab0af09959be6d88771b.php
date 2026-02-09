

<?php $__env->startSection('title', 'Login - Gestor de Usuarios'); ?>

<?php $__env->startSection('content'); ?>
<div class="login-page">
    <div class="card login-card">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 2.5rem; color: var(--primary);">Laravel<span style="color: #fff">Admin</span></h1>
            <p style="color: var(--text-muted);">Bienvenido de nuevo</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert alert-error">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group" style="display: flex; align-items: center; justify-content: space-between;">
                <label style="display: flex; align-items: center; gap: 0.5rem; margin: 0; cursor: pointer;">
                    <input type="checkbox" name="remember" style="width: auto;">
                    Recordarme
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">
                Iniciar Sesión
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\usuarios\resources\views/auth/login.blade.php ENDPATH**/ ?>