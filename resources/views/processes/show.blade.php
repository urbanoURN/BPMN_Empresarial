@extends('layouts.app')
@section('title', $process->name)

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center">
        <a href="{{ route('processes.index') }}" class="btn btn-sm me-3" style="border-color: var(--color-primary); color: var(--color-primary);">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 mb-0 fw-bold" style="color: var(--color-dark);">
                {{ $process->name }}
            </h1>
            <small class="text-muted">
                <i class="bi bi-eye me-1"></i>Modo solo lectura
            </small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('processes.export', $process) }}" class="btn btn-sm fw-semibold" style="border-color: var(--color-success); color: var(--color-success);">
            <i class="bi bi-download me-1"></i>Exportar .bpmn
        </a>
        <a href="{{ route('processes.edit', $process) }}" class="btn btn-sm text-white fw-semibold" style="background-color: var(--color-primary); border-color: var(--color-primary);">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
    </div>
</div>

<div class="row g-4">

    <!-- INFO -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-0 fw-semibold" style="background-color: var(--color-light); color: var(--color-dark);">
                <i class="bi bi-info-circle me-2" style="color: var(--color-primary);"></i>
                Información
            </div>
            <div class="card-body">
                <dl class="row mb-0 small">
                    <dt class="col-5 text-muted">Nombre</dt>
                    <dd class="col-7 fw-semibold">{{ $process->name }}</dd>

                    <dt class="col-5 text-muted">Descripción</dt>
                    <dd class="col-7">{{ $process->description ?? 'Sin descripción.' }}</dd>

                    <dt class="col-5 text-muted">Creado</dt>
                    <dd class="col-7">{{ $process->created_at->format('d/m/Y H:i') }}</dd>

                    <dt class="col-5 text-muted">Modificado</dt>
                    <dd class="col-7">{{ $process->updated_at->diffForHumans() }}</dd>
                </dl>
            </div>
            <div class="card-footer border-0" style="background-color: var(--color-light);">
                <form id="delete-form-{{ $process->id }}" method="POST" action="{{ route('processes.destroy', $process) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-delete-trigger" data-form-id="delete-form-{{ $process->id }}" style="border-color: var(--color-danger); color: var(--color-danger);" title="Eliminar">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- VIEWER -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-0" style="background-color: var(--color-light);">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="fw-semibold" style="color: var(--color-dark);">
                        <i class="bi bi-diagram-2 me-2" style="color: var(--color-primary);"></i>
                        Diagrama BPMN
                    </span>
                    <span class="badge" style="background-color: rgba(30,164,217,0.1); color: var(--color-primary); border: 1px solid rgba(30,164,217,0.3);">
                        Solo lectura
                    </span>
                </div>
            </div>
            <div class="card-body p-0">
                <script id="bpmn-xml-data" type="application/xml">
                    {!! $process->bpmn_xml !!}
                </script>
                <div id="bpmn-viewer-container"></div>
            </div>
            <div class="card-footer border-0 text-muted small" style="background-color: var(--color-light);">
                <i class="bi bi-hand-index me-1" style="color: var(--color-warning);"></i>
                Scroll para zoom · Arrastra para mover el diagrama.
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
    @vite(['resources/js/bpmn-viewer.js'])
@endpush