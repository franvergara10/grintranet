<?php $__env->startSection('title', 'Ausencias - ' . \Carbon\Carbon::parse($date)->format('d/m/Y')); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1 class="page-title">Ausencias - <?php echo e(\Carbon\Carbon::parse($date)->format('d/m/Y')); ?></h1>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <form action="<?php echo e(route('ausencias.index')); ?>" method="GET" style="display: flex; gap: 0.5rem;">
                <input type="date" name="date" value="<?php echo e($date); ?>" class="form-control" onchange="this.form.submit()">
            </form>
            <a href="<?php echo e(route('ausencias.create', ['date' => $date])); ?>" class="btn btn-primary">
                + Nueva Ausencia
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert"
            style="background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="card" style="padding: 0; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: rgba(255,255,255,0.02);">
                    <th
                        style="padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: left; width: 150px;">
                        Horario
                    </th>
                    <th style="padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: left;">
                        Ausencias
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $timeSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $slotAusencias = $ausencias[$slot->id] ?? collect();
                    ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); height: 100px;">
                        <td style="padding: 1rem; vertical-align: top; border-right: 1px solid rgba(255,255,255,0.05);">
                            <div style="font-weight: 600;"><?php echo e($slot->name); ?></div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">
                                <?php echo e(\Carbon\Carbon::parse($slot->start_time)->format('H:i')); ?> -
                                <?php echo e(\Carbon\Carbon::parse($slot->end_time)->format('H:i')); ?>

                            </div>
                        </td>
                        <td style="padding: 0.5rem; vertical-align: top; position: relative;">
                            <?php if($slotAusencias->isNotEmpty()): ?>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <?php $__currentLoopData = $slotAusencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ausencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card"
                                            style="margin: 0; padding: 1rem; background: rgba(56, 189, 248, 0.1); border: 1px solid rgba(56, 189, 248, 0.2);">
                                            <div
                                                style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem; gap: 1rem;">
                                                <div style="font-weight: 700; color: #fff; font-size: 1.1rem; line-height: 1.2;">
                                                    <?php echo e($ausencia->group->course); ?> <?php echo e($ausencia->group->name); ?>

                                                </div>
                                                <div
                                                    style="font-size: 1.1rem; font-weight: 700; color: var(--primary); text-align: right; background: rgba(56, 189, 248, 0.1); padding: 0.2rem 0.6rem; border-radius: 0.4rem; white-space: nowrap;">
                                                    📍 <?php echo e($ausencia->zona->nombre); ?>

                                                </div>
                                            </div>

                                            <div
                                                style="font-size: 0.95rem; color: #fff; margin-bottom: 0.75rem; background: rgba(255,255,255,0.03); padding: 0.5rem; border-radius: 0.4rem;">
                                                <?php echo e($ausencia->tarea); ?>

                                            </div>

                                            <div style="display: flex; align-items: center; justify-content: left; font-size: 0.95rem;">
                                                <div style="color: var(--text-muted);">Profesor:</div>
                                                <div style="font-weight: 600; color: var(--primary);">
                                                    👤 <?php echo e($ausencia->user->name); ?>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <!-- Clickable empty area to create absence -->
                                <a href="<?php echo e(route('ausencias.create', ['date' => $date, 'time_slot_id' => $slot->id])); ?>"
                                    style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; min-height: 80px; border: 2px dashed rgba(255,255,255,0.1); border-radius: 0.5rem; color: rgba(255,255,255,0.3); text-decoration: none; transition: all 0.2s;">
                                    <span style="font-size: 1.5rem;">+</span>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <style>
        a[href*="create"]:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--primary) !important;
            border-color: var(--primary) !important;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\grintranet\resources\views/ausencias/index.blade.php ENDPATH**/ ?>