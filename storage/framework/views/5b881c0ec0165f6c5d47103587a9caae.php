<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        /** @var \App\Models\User $user */
        $user = Auth::user();
    ?>
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <div style="color: var(--text-muted);">
            Bienvenido, <?php echo e($user->name); ?>

        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Total Usuarios</h3>
            <div style="font-size: 3rem; font-weight: 700; color: var(--primary);"><?php echo e($usersCount); ?></div>
            <a href="<?php echo e(route('users.index')); ?>"
                style="display: inline-block; margin-top: 1rem; font-size: 0.9rem;">Gestionar Usuarios &rarr;</a>
        </div>

        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Total Roles</h3>
            <div style="font-size: 3rem; font-weight: 700; color: var(--success);"><?php echo e($rolesCount); ?></div>
            <a href="<?php echo e(route('roles.index')); ?>"
                style="display: inline-block; margin-top: 1rem; font-size: 0.9rem; color: var(--success);">Gestionar Roles
                &rarr;</a>
        </div>

        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Total Grupos</h3>
            <div style="font-size: 3rem; font-weight: 700; color: #f59e0b;"><?php echo e($groupsCount); ?></div>
            <a href="<?php echo e(route('groups.index')); ?>"
                style="display: inline-block; margin-top: 1rem; font-size: 0.9rem; color: #f59e0b;">Gestionar Grupos
                &rarr;</a>
        </div>

        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Total Zonas</h3>
            <div style="font-size: 3rem; font-weight: 700; color: #10b981;"><?php echo e($zonasCount); ?></div>
            <a href="<?php echo e(route('zonas.index')); ?>"
                style="display: inline-block; margin-top: 1rem; font-size: 0.9rem; color: #10b981;">Gestionar Zonas
                &rarr;</a>
        </div>
        <?php endif; ?>

        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'profesor')): ?>
        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Mis Alumnos Totales</h3>
            <div style="font-size: 3rem; font-weight: 700; color: var(--primary);"><?php echo e($myStudentsCount); ?></div>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.5rem;">Suma de alumnos en todos tus grupos
                tutorizados.</p>
        </div>

        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Grupos Tutorizados</h3>
            <div style="font-size: 3rem; font-weight: 700; color: var(--success);"><?php echo e($myGroups->count()); ?></div>
            <a href="<?php echo e(route('groups.index')); ?>"
                style="display: inline-block; margin-top: 1rem; font-size: 0.9rem; color: var(--success);">Ver Mis Grupos
                &rarr;</a>
        </div>
        <?php endif; ?>

        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Mi Perfil</h3>
            <div style="margin-top: 0.5rem; display: flex; flex-direction: column; gap: 1rem;">
                <div>
                    <?php $__currentLoopData = $user->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge badge-role"
                            style="font-size: 0.85rem; padding: 0.4rem 0.8rem;"><?php echo e(ucfirst($role)); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <a href="<?php echo e(route('profile.edit')); ?>" style="font-size: 0.9rem;">Editar Perfil &rarr;</a>
            </div>
        </div>

        <!-- NEW: Personal Schedule Shortcut -->
        <div class="card shadow-hover"
            style="border: 2px dashed rgba(56, 189, 248, 0.3); background: rgba(56, 189, 248, 0.02);">
            <h3
                style="color: var(--primary); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Personalización</h3>
            <div style="font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem;">Mi Horario</div>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1rem;">Configura tus guardias y
                actividades sobre una plantilla.</p>
            <a href="<?php echo e(route('personal-schedules.index')); ?>"
                style="display: inline-block; font-size: 0.9rem; color: var(--primary); font-weight: 600;">Ir a mi horario
                &rarr;</a>
        </div>
    </div>

    <?php if($user->hasRole('profesor') && $myGroups->isNotEmpty()): ?>
        <div class="card" style="margin-top: 2rem;">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.25rem; color: #fff;">Resumen de Mis Grupos</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Grupo</th>
                            <th>Nº Alumnos</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $myGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="color: var(--primary); font-weight: 500;"><?php echo e($group->course); ?></td>
                                <td style="font-weight: 600;"><?php echo e($group->name); ?></td>
                                <td><span class="badge badge-role"><?php echo e($group->students_count); ?></span></td>
                                <td>
                                    <a href="<?php echo e(route('groups.show', $group)); ?>" class="btn"
                                        style="background: rgba(56, 189, 248, 0.1); color: var(--primary); padding: 0.3rem 0.6rem; font-size: 0.8rem;">Ver
                                        Alumnos</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\grintranet\resources\views/dashboard.blade.php ENDPATH**/ ?>