@extends('layouts.app')
@section('title', 'Nuevo Proceso BPMN')

@section('content')

<!-- ENCABEZADO -->
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('processes.index') }}"
       class="btn btn-sm me-3"
       style="border-color: var(--color-primary); color: var(--color-primary);">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h1 class="h3 mb-0 fw-bold" style="color: var(--color-dark);">
            Nuevo Proceso BPMN
        </h1>
        <small class="text-muted">Diseña el diagrama y completa los datos.</small>
    </div>
</div>

<form id="process-form" method="POST" action="{{ route('processes.store') }}">
    @csrf
    <div class="row g-4">

        <!-- EDITOR — arriba en móvil, derecha en desktop -->
        <div class="col-12 col-lg-8 order-1 order-lg-2">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0"
                     style="background-color: var(--color-light);">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <span class="fw-semibold" style="color: var(--color-dark);">
                            <i class="bi bi-pencil-square me-2"
                               style="color: var(--color-primary);"></i>
                            Editor de Diagrama
                        </span>
                        <div class="d-flex gap-2">
                            <button type="button" id="btn-undo" class="btn btn-sm" style="border-color: var(--color-primary); color: var(--color-primary);" title="Deshacer">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                            <button type="button" id="btn-redo" class="btn btn-sm" style="border-color: var(--color-primary); color: var(--color-primary);" title="Rehacer">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                            <button type="button" id="btn-fit-viewport" class="btn btn-sm" style="border-color: var(--color-primary); color: var(--color-primary);" title="Centrar">
                                <i class="bi bi-fullscreen"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="bpmn-container"></div>
                </div>
                <div class="card-footer border-0 text-muted small" style="background-color: var(--color-light);">
                    <i class="bi bi-info-circle me-1" style="color: var(--color-warning);"></i>
                    Arrastra elementos del panel para construir tu diagrama.
                    Doble clic para editar.
                </div>
            </div>
        </div>

        <!-- DATOS — abajo en móvil, izquierda en desktop -->
        <div class="col-12 col-lg-4 order-2 order-lg-1">
            <div class="card border-0 shadow-sm sticky-sidebar">
                <div class="card-header border-0 fw-semibold" style="background-color: var(--color-light); color: var(--color-dark);">
                    <i class="bi bi-info-circle me-2" style="color: var(--color-primary);"></i>
                    Datos del Proceso
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold small text-muted text-uppercase">
                            Nombre <span style="color: var(--color-danger);">*</span>
                        </label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ej: Proceso de ventas" maxlength="100" required/>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold small text-muted text-uppercase">
                            Descripción
                        </label>
                        <textarea id="description" name="description" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="Describe brevemente el proceso...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" id="bpmn_xml" name="bpmn_xml" value="{{ old('bpmn_xml') }}"/>
                    @error('bpmn_xml')
                        <div class="alert border-0 py-2 small" style="background-color: rgba(242,56,56,0.1); color: var(--color-danger);">
                            <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="card-footer border-0 d-grid"
                     style="background-color: var(--color-light);">
                    <button type="submit" class="btn text-white fw-semibold" style="background-color: var(--color-success); border-color: var(--color-success);">
                        <i class="bi bi-save me-1"></i>Guardar Proceso
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
    @vite(['resources/js/bpmn-editor.js'])
@endpush