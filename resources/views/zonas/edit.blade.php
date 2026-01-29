@extends('layouts.app')

@section('title', 'Editar Zona')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Editar Zona</h1>
        <a href="{{ route('zonas.index') }}" class="btn">Volver</a>
    </div>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <form action="{{ route('zonas.update', $zona) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="nombre" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                    value="{{ old('nombre', $zona->nombre) }}" required>
                @error('nombre')
                    <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="planta" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Planta</label>
                <input type="text" name="planta" id="planta" class="form-control @error('planta') is-invalid @enderror"
                    value="{{ old('planta', $zona->planta) }}" required>
                @error('planta')
                    <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                <a href="{{ route('zonas.index') }}" class="btn" style="background: rgba(255, 255, 255, 0.1);">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
@endsection