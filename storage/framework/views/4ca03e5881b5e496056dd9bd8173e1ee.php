

<?php $__env->startSection('title', 'Plantillas de Horario'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header-actions">
        <h1>Plantillas de Horario</h1>
        <a href="<?php echo e(route('schedule-templates.create')); ?>" class="btn-primary">
            + Crear Nueva Plantilla
        </a>
    </div>

    <div class="card" style="margin-top: 20px;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Días Activos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <strong><?php echo e($template->name); ?></strong>
                            <?php if($template->description): ?>
                                <div style="font-size: 0.85em; color: #666;"><?php echo e($template->description); ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($template->active_days): ?>
                                <?php echo e(implode(', ', $template->active_days)); ?>

                            <?php else: ?>
                                <em>No definidos</em>
                            <?php endif; ?>
                        </td>
                        <td class="actions-cell">
                            <a href="<?php echo e(route('schedule-templates.preview', $template->id)); ?>" class="btn-icon"
                                title="Vista Previa" target="_blank">
                                👁️
                            </a>
                            <a href="<?php echo e(route('schedule-templates.edit', $template->id)); ?>" class="btn-icon" title="Editar">
                                ✏️
                            </a>
                            <form action="<?php echo e(route('schedule-templates.destroy', $template->id)); ?>" method="POST"
                                style="display:inline;" onsubmit="return confirm('¿Estás seguro?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn-icon delete" title="Eliminar">🗑️</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 20px;">No hay plantillas creadas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <style>
        /* Inline styles for quick implementation matching likely existing styles */
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-actions h1 {
            color: #ffffff;
        }

        .btn-primary {
            background-color: #4f46e5;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #4338ca;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .data-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #000000;
        }

        .data-table td {
            color: #000000;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .actions-cell {
            display: flex;
            gap: 10px;
        }

        .btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1em;
            text-decoration: none;
        }

        .btn-icon.delete {
            color: #ef4444;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\grintranet\resources\views/schedule_templates/index.blade.php ENDPATH**/ ?>