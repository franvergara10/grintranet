<?php $__env->startSection('title', 'Mi Perfil - Gestor de Usuarios'); ?>

<?php $__env->startSection('content'); ?>
    <div class="profile-container" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
        <div class="card"
            style="background: var(--card-bg); border: 1px solid var(--border); border-radius: 1rem; padding: 2rem;">
            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.8rem; color: #fff; margin-bottom: 0.5rem;">Mi Perfil</h2>
                <p style="color: var(--text-muted);">Gestiona tu información personal y seguridad.</p>
            </div>

            <?php if(session('status')): ?>
                <div class="alert alert-success"
                    style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1rem; border-radius: 0.5rem; border: 1px solid rgba(16, 185, 129, 0.2); margin-bottom: 1.5rem;">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-error"
                    style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 1rem; border-radius: 0.5rem; border: 1px solid rgba(239, 68, 68, 0.2); margin-bottom: 1.5rem;">
                    <ul style="margin: 0; padding-left: 1.2rem;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <?php if(!$isAlumno): ?>
                    <div
                        style="display: flex; align-items: center; gap: 2rem; margin-bottom: 2rem; padding: 1.5rem; background: rgba(255,255,255,0.02); border-radius: 1rem; border: 1px solid var(--border);">
                        <div style="position: relative; width: 100px; height: 100px;">
                            <?php if($user->avatar): ?>
                                <img src="<?php echo e(asset('storage/' . $user->avatar)); ?>" alt="Avatar"
                                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary);">
                            <?php else: ?>
                                <div
                                    style="width: 100px; height: 100px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 700; border: 3px solid var(--primary);">
                                    <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label for="avatar"
                                style="display: block; margin-bottom: 0.5rem; color: #fff; font-weight: 600;">Foto de
                                Perfil</label>
                            <input type="file" id="avatar" name="avatar" accept="image/*"
                                style="font-size: 0.9rem; color: var(--text-muted);">
                            <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.5rem;">PNG, JPG o GIF. Máx.
                                2MB.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label for="name"
                            style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Nombre</label>
                        <input type="text" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>"
                            style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: #fff;"
                            <?php echo e($isAlumno ? 'readonly disabled' : ''); ?>>
                    </div>

                    <div class="form-group">
                        <label for="last_name"
                            style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Apellidos</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo e(old('last_name', $user->last_name)); ?>"
                            style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: #fff;"
                            <?php echo e($isAlumno ? 'readonly disabled' : ''); ?>>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="email"
                        style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Correo
                        Electrónico</label>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>"
                        style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: #fff;"
                        <?php echo e($isAlumno ? 'readonly disabled' : ''); ?>>
                </div>

                <hr style="border: 0; border-top: 1px solid var(--border); margin: 2rem 0;">

                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.2rem; color: #fff; margin-bottom: 0.5rem;">Cambiar Contraseña</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Deja los campos en blanco si no deseas
                        cambiarla.</p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label for="password"
                            style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Nueva
                            Contraseña</label>
                        <input type="password" id="password" name="password"
                            style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: #fff;">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation"
                            style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Confirmar
                            Contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: #fff;">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-weight: 600;">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mgonpor116\Desktop\grintranet\resources\views/profile/edit.blade.php ENDPATH**/ ?>