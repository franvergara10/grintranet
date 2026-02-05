---
name: generador_crud_laravel
description: Genera módulos CRUD completos y funcionales en Laravel 11 con Livewire, Tailwind CSS y edición inline.
---
# Generador de CRUD Laravel

Esta habilidad permite generar un módulo CRUD (Create, Read, Update, Delete) completo en Laravel 11 a partir de un único nombre de entidad.

## Reglas de Generación
El flujo de trabajo es estricto y debe cumplir con los siguientes estándares:

### 1. Generación Integral
Al recibir el nombre de la entidad (ej. "Vehículo"), debes generar TODOS los archivos necesarios:
1.  **Modelo** (`app/Models/Vehiculo.php`)
2.  **Migración** (`database/migrations/xxxx_xx_xx_create_vehiculos_table.php`)
3.  **Controlador/Componente Livewire** (`app/Livewire/Vehiculos/Index.php`, etc.)
4.  **Vistas** (Blade templates con componentes Livewire)
5.  **Rutas** (`routes/web.php`)

### 2. Tablas Inteligentes (Livewire + Tailwind)
La tabla de listado debe implementar:
*   **Búsqueda en tiempo real**: Un input que filtra los resultados dinámicamente (`wire:model.live.debounce.300ms`).
*   **Ordenación**: Encabezados de columna clicables que alternan entre ASC/DESC.
*   **Paginación**: Uso de `use WithPagination;` de Livewire y estilos de Tailwind.
*   **Diseño**: Estética limpia usando clases de Tailwind CSS.

### 3. Edición Inline (Reactividad Pro)
*   **Doble Clic para Editar**: Implementa funcionalidad (Alpine.js o Livewire) donde hacer doble clic en una celda de texto la convierte en un input.
*   **Guardado Automático/Blur**: Al salir del input (blur) o dar Enter, se debe enviar la actualización al servidor.
*   **Feedback Visual**: Mostrar un "toast" o notificación flotante ("Registro actualizado") tras el guardado exitoso.

### 4. Calidad de Código (Laravel 11)
*   Usa la sintaxis moderna de Laravel 11.
*   Implementa `Request` validation o validación en el componente Livewire (`$rules`).
*   Usa Componentes de Blade anónimos (`<x-input ... />`) si están disponibles o genera código HTML limpio con Tailwind.

## Instrucciones para el Agente
Cuando el usuario pida "Generar CRUD para [Entidad]":

1.  **Analiza la Entidad**: Si el usuario no especifica campos, propón un esquema lógico básico (ej. para Vehículo: marca, modelo, año, placa) o pregúntale antes de generar código.
2.  **Genera la Migración**: Define la estructura de base de datos.
3.  **Genera el Modelo**: Incluye `$fillable` y relaciones si aplica.
4.  **Genera el Componente Livewire Principal**:
    *   Logica de `render()` con búsqueda y ordenamiento.
    *   Métodos `updateField($id, $field, $value)` para la edición inline.
5.  **Genera la Vista Blade**:
    *   Tabla con iteración `@foreach`.
    *   Celdas con `x-data="{ editing: false, ... }"` para controlar la edición inline.

## Ejemplo de Edición Inline (Snippet Recomendado)
```html
<td x-data="{ editing: false }" class="px-6 py-4 whitespace-nowrap">
    <div x-show="!editing" @dblclick="editing = true; $nextTick(() => $refs.input.focus())" class="cursor-pointer hover:bg-gray-50 p-2 rounded">
        {{ $item->name }}
    </div>
    <div x-show="editing" style="display: none;">
        <input 
            x-ref="input"
            type="text" 
            class="w-full border-gray-300 rounded shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            wire:model.live="form.name"
            @keydown.enter="editing = false; $wire.update({{ $item->id }})"
            @blur="editing = false; $wire.update({{ $item->id }})"
        >
    </div>
</td>
```
