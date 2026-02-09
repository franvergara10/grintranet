<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Gestor de Usuarios'); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
</head>
<body>
    <?php if(auth()->guard()->check()): ?>
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-title">
                Laravel<span style="color: #fff">Admin</span>
            </div>
            
            <ul class="nav-links">
                <li>
                    <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                        Dashboard
                    </a>
                </li>
                <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                <li>
                    <a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
                        Usuarios
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('roles.index')); ?>" class="nav-link <?php echo e(request()->routeIs('roles.*') ? 'active' : ''); ?>">
                        Roles
                    </a>
                </li>
                <?php endif; ?>
                
                <li style="margin-top: auto;">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="nav-link" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                            Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <main class="main-content">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
    <?php else: ?>
        <?php echo $__env->yieldContent('content'); ?>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\usuarios\resources\views/layouts/app.blade.php ENDPATH**/ ?>