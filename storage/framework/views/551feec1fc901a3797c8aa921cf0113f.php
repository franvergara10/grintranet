

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <div style="color: var(--text-muted);">
        Bienvenido, <?php echo e(Auth::user()->name); ?>

    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
    <div class="card">
        <h3 style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">Total Usuarios</h3>
        <div style="font-size: 3rem; font-weight: 700; color: var(--primary);"><?php echo e($usersCount); ?></div>
        <a href="<?php echo e(route('users.index')); ?>" style="display: inline-block; margin-top: 1rem; font-size: 0.9rem;">Gestianar Usuarios &rarr;</a>
    </div>

    <div class="card">
        <h3 style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">Total Roles</h3>
        <div style="font-size: 3rem; font-weight: 700; color: var(--success);"><?php echo e($rolesCount); ?></div>
        <a href="<?php echo e(route('roles.index')); ?>" style="display: inline-block; margin-top: 1rem; font-size: 0.9rem; color: var(--success);">Gestianar Roles &rarr;</a>
    </div>

    <div class="card">
        <h3 style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">Mi Rol</h3>
        <div style="margin-top: 0.5rem;">
            <?php $__currentLoopData = Auth::user()->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="badge badge-role" style="font-size: 1rem; padding: 0.5rem 1rem;"><?php echo e($role); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\usuarios\resources\views/dashboard.blade.php ENDPATH**/ ?>