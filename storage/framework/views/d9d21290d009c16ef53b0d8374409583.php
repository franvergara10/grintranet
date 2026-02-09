<?php $__env->startSection('title', 'Editar Mi Horario'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Mi Horario Personal</h1>
            <p style="color: var(--text-muted);">Basado en: <strong><?php echo e($template->name); ?></strong></p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="<?php echo e(route('personal-schedules.index')); ?>" class="btn"
                style="background: rgba(255,255,255,0.05);">Cancelar</a>
            <button type="button" onclick="saveSchedule()" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </div>

    <div class="card" style="padding: 0; overflow-x: auto;">
        <form id="scheduleForm" action="<?php echo e(route('personal-schedules.update', $personal_schedule)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
                <thead>
                    <tr style="background: rgba(255,255,255,0.02);">
                        <th
                            style="padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: left; width: 200px;">
                            Tramo Horario</th>
                        <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th style="padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: center;">
                                <?php echo e($day); ?>

                            </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td style="padding: 1rem 1.5rem;">
                                <div style="font-weight: 600;"><?php echo e($slot->name); ?></div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">
                                    <?php echo e(\Carbon\Carbon::parse($slot->start_time)->format('H:i')); ?> -
                                    <?php echo e(\Carbon\Carbon::parse($slot->end_time)->format('H:i')); ?>

                                </div>
                            </td>
                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $key = $slot->id . '-' . $day;
                                    $currentSelection = $selections[$key] ?? null;
                                ?>
                                <td style="padding: 0.5rem; text-align: center;">
                                    <div class="schedule-cell" style="position: relative;">
                                        <select name="selections[<?php echo e($slot->id); ?>][<?php echo e($day); ?>]" class="form-control select-activity"
                                            style="width: 100%; padding: 0.5rem; border-radius: 0.4rem; background: <?php echo e($currentSelection ? 'rgba(56, 189, 248, 0.1)' : 'var(--bg-card)'); ?>; color: #fff; border: 1px solid <?php echo e($currentSelection ? 'var(--primary)' : 'rgba(255,255,255,0.05)'); ?>;"
                                            onchange="this.style.background = this.value ? 'rgba(56, 189, 248, 0.1)' : 'var(--bg-card)'; this.style.borderColor = this.value ? 'var(--primary)' : 'rgba(255,255,255,0.05)';">
                                            <option value="" style="color: #000; background: #fff;">Vacío</option>
                                            <?php $__currentLoopData = $guardias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guardia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="guardia_<?php echo e($guardia->id); ?>" style="color: #000; background: #fff;" 
                                                    <?php echo e(($currentSelection && $currentSelection->guardia_id == $guardia->id) ? 'selected' : ''); ?>>
                                                    Guardia (<?php echo e($guardia->name); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <option value="Otras" style="color: #000; background: #fff;" <?php echo e(($currentSelection && $currentSelection->value == 'Otras') ? 'selected' : ''); ?>>Otras</option>
                                        </select>
                                    </div>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </form>
    </div>

    <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
        <button type="button" onclick="saveSchedule()" class="btn btn-primary" style="padding: 1rem 2rem;">Guardar Mi
            Horarios</button>
    </div>

    <script shadow>
        function saveSchedule() {
            const form = document.getElementById('scheduleForm');
            const formData = new FormData(form);

            // Show loading state
            const btn = event.target;
            const originalText = btn.innerText;
            btn.innerText = 'Guardando...';
            btn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "<?php echo e(route('personal-schedules.index')); ?>";
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al guardar.');
                })
                .finally(() => {
                    btn.innerText = originalText;
                    btn.disabled = false;
                });
        }

        function showToast(message) {
            // Check if toast element exists
            let toast = document.getElementById('toast-notification');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast-notification';
                toast.style.cssText = 'position: fixed; bottom: 2rem; right: 2rem; background: var(--success); color: #fff; padding: 1rem 2rem; border-radius: 0.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 9999; transform: translateY(100px); transition: transform 0.3s ease;';
                document.body.appendChild(toast);
            }

            toast.innerText = message;
            toast.style.transform = 'translateY(0)';

            setTimeout(() => {
                toast.style.transform = 'translateY(100px)';
            }, 3000);
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mgonpor116\Desktop\grintranet\resources\views/personal_schedules/edit.blade.php ENDPATH**/ ?>