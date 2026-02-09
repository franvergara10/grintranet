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

                <div class="user-sidebar-info"
                    style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; padding: 1rem; background: rgba(255,255,255,0.03); border-radius: 0.75rem;">
                    <?php if(Auth::user()->avatar): ?>
                        <img src="<?php echo e(asset('storage/' . Auth::user()->avatar)); ?>" alt="Avatar"
                            style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <?php else: ?>
                        <div
                            style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem;">
                            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                        </div>
                    <?php endif; ?>
                    <div style="overflow: hidden;">
                        <div
                            style="font-weight: 600; font-size: 0.9rem; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?php echo e(Auth::user()->name); ?></div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">
                            <?php echo e(ucfirst(Auth::user()->getRoleNames()[0] ?? '')); ?></div>
                    </div>
                </div>

                <ul class="nav-links">
                    <li>
                        <a href="<?php echo e(route('dashboard')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('profile.edit')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>">
                            Mi Perfil
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('calendar.index')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('calendar.*') ? 'active' : ''); ?>">
                            Calendario Escolar
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('schedule-templates.index')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('schedule-templates.*') ? 'active' : ''); ?>">
                            Plantillas Horario
                        </a>
                    </li>
                    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'profesor')): ?>
                    <li>
                        <a href="<?php echo e(route('groups.index')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('groups.*') ? 'active' : ''); ?>">
                            Mis Grupos
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                    <li>
                        <a href="<?php echo e(route('groups.index')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('groups.*') ? 'active' : ''); ?>">
                            Grupos
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('users.index')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
                            Usuarios
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('roles.index')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('roles.*') ? 'active' : ''); ?>">
                            Roles
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('zonas.index')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('zonas.*') ? 'active' : ''); ?>">
                            Zonas
                        </a>
                    </li>
                    <?php endif; ?>

                    <li style="margin-top: auto;">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="nav-link"
                                style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
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

</html><?php /**PATH C:\laragon\www\grintranet\usuarios_v4\usuarios\resources\views/layouts/app.blade.php ENDPATH**/ ?>