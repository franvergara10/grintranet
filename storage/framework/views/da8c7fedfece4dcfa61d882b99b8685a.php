<?php $__env->startSection('title', 'Elegir Plantilla de Horario'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1 class="page-title">Elegir Plantilla</h1>
        <a href="<?php echo e(route('personal-schedules.index')); ?>" style="color: var(--text-muted);">&larr; Volver</a>
    </div>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <p style="margin-bottom: 2rem; color: var(--text-muted);">
            Selecciona una base horaria para crear tu instancia personal. Una vez creada, podrás asignar tus guardias o
            actividades a cada tramo.
        </p>

        <form action="<?php echo e(route('personal-schedules.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group" style="margin-bottom: 2rem;">
                <label for="schedule_template_id" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Plantilla
                    disponible:</label>
                <select name="schedule_template_id" id="schedule_template_id" class="form-control"
                    style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: var(--bg-card); color: #fff; border: 1px solid rgba(255,255,255,0.1);">
                    <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($template->id); ?>">
                            <?php echo e($template->name); ?> (<?php echo e(count($template->active_days ?? [])); ?> días,
                            <?php echo e($template->timeSlots->count()); ?> tramos)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">
                Instanciar Horario
            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\grintranet\resources\views/personal_schedules/create.blade.php ENDPATH**/ ?>