

<?php $__env->startSection('title', 'Importación Masiva de Alumnos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1 class="page-title">Importación Masiva</h1>
        <a href="<?php echo e(route('users.index')); ?>" class="btn" style="background: rgba(255, 255, 255, 0.1);">Volver</a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Formulario de Importación -->
        <div class="card">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.25rem;">Configurar Importación</h2>

            <form action="<?php echo e(route('users.import.process')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>



                <hr style="border: 0; border-top: 1px solid var(--border); margin: 2rem 0;">

                <div class="form-group">
                    <label for="import_file">Opción 1: Subir Archivo CSV</label>
                    <input type="file" name="import_file" id="import_file" accept=".csv">
                    <p style="font-size: 0.8rem; color: var(--text-muted); mt-1">Formato: Nombre, Apellidos, Email, Curso,
                        Grupo (sin
                        cabecera)</p>
                </div>

                <div style="text-align: center; margin: 1.5rem 0; color: var(--text-muted); font-weight: 600;">O BIEN</div>

                <div class="form-group">
                    <label for="import_list">Opción 2: Pegar Lista de Alumnos</label>
                    <textarea name="import_list" id="import_list" rows="10"
                        placeholder="Nombre, Apellidos, Email, Curso, Grupo&#10;Juan, Pérez, juan@instituto.es, Bach, 2º&#10;María, García, maria@instituto.es, ESO, 3º"
                        style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid var(--border); border-radius: 0.5rem; color: #fff; padding: 1rem; font-family: monospace;"></textarea>
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary"
                        style="width: 100%; justify-content: center; padding: 1rem;">
                        🚀 Iniciar Importación de Alumnos
                    </button>
                </div>
            </form>
        </div>

        <!-- Instrucciones y Ayuda -->
        <div class="card" style="background: rgba(56, 189, 248, 0.05);">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.25rem; color: var(--primary);">Guía de Importación</h2>

            <div style="display: flex; flex-direction: column; gap: 1.5rem; color: var(--text-muted); font-size: 0.95rem;">
                <div style="display: flex; gap: 1rem;">
                    <div
                        style="background: var(--primary); color: #fff; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        1</div>
                    <p>Prepara tu lista en Excel o Google Sheets con las columnas: <strong style="color: #fff;">Nombre,
                            Apellidos, Email, Curso, Grupo</strong>.</p>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <div
                        style="background: var(--primary); color: #fff; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        2</div>
                    <p>Exporta el archivo como <strong style="color: #fff;">CSV (delimitado por comas)</strong> o
                        simplemente copia y pega las filas en el cuadro de la izquierda.</p>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <div
                        style="background: var(--primary); color: #fff; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        3</div>
                    <p>Los alumnos recibirán el rol <span class="badge badge-role">alumno</span> automáticamente.</p>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <div
                        style="background: var(--success); color: #fff; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        ✓</div>
                    <p><strong style="color: #fff;">Vinculación con Google:</strong> Cuando el alumno inicie sesión con su
                        correo corporativo, Laravel reconocerá su email y le dará acceso a este perfil ya creado.</p>
                </div>
            </div>

            <div
                style="margin-top: 3rem; padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 0.5rem; border-left: 4px solid var(--primary);">
                <p style="font-style: italic; font-size: 0.85rem;">"Esta herramienta permite precargar a todos los alumnos
                    de un curso en segundos sin que ellos tengan que registrarse manualmente."</p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\grintranet\usuarios_v4\usuarios\resources\views/users/import.blade.php ENDPATH**/ ?>