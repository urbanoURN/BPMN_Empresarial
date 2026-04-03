@extends('layouts.app')
@section('title', 'Procesos BPMN')

@section('content')

<!-- ENCABEZADO -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold" style="color: var(--color-dark);">
            <i class="bi bi-diagram-3 me-2" style="color: var(--color-primary);"></i>
            Procesos BPMN
        </h1>
        <small class="text-muted">{{ $processes->total() }} proceso(s) registrado(s)</small>
    </div>
    <a href="{{ route('processes.create') }}" class="btn btn-sm d-none d-lg-inline-flex align-items-center gap-1 text-white" style="background-color: var(--color-primary); border-color: var(--color-primary);">
        <i class="bi bi-plus-circle"></i> Nuevo Proceso
    </a>
</div>

<!-- BÚSQUEDA -->
<div class="card border-0 shadow-sm mb-4" style="background-color: var(--color-light);">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('processes.index') }}" class="row g-2 align-items-center">
            <div class="col-md-8 search-wrapper">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="search" class="form-control border-0 bg-light" placeholder="Buscar proceso por nombre..." value="{{ request('search') }}"/>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn w-100 text-white" style="background-color: var(--color-primary);">
                    <i class="bi bi-search me-1"></i>Buscar
                </button>
            </div>
            @if(request('search'))
            <div class="col-md-2">
                <a href="{{ route('processes.index') }}" class="btn w-100" style="border-color: var(--color-danger); color: var(--color-danger);">
                    <i class="bi bi-x-circle me-1"></i>Limpiar
                </a>
            </div>
            @endif
        </form>
    </div>
</div>

<!-- LISTADO -->
@if($processes->isEmpty())
    <div class="text-center py-5">
        <div class="mb-3">
            <i class="bi bi-inbox display-1" style="color: var(--color-primary); opacity: 0.3;"></i>
        </div>
        <h4 class="text-muted">
            {{ request('search')
                ? 'Sin resultados para "' . request('search') . '"'
                : 'No hay procesos registrados aún.' }}
        </h4>
        @unless(request('search'))
            <a href="{{ route('processes.create') }}" class="btn mt-3 text-white" style="background-color: var(--color-primary);">
                <i class="bi bi-plus-circle me-1"></i>Crear el primero
            </a>
        @endunless
    </div>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($processes as $process)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm process-card">
                <div class="card-body">

                    <!-- Ícono + badge -->
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="rounded-3 p-2" style="background-color: rgba(30,164,217,0.1);">
                            <i class="bi bi-diagram-2 fs-4" style="color: var(--color-primary);"></i>
                        </div>
                        <span class="badge status-badge bg-success-subtle border">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                            Activo
                        </span>
                    </div>

                    <!-- Nombre y descripción -->
                    <h5 class="fw-semibold mb-1" style="color: var(--color-dark);">
                        {{ $process->name }}
                    </h5>
                    <p class="text-muted small mb-3" style="min-height: 2.5rem;">
                        {{ $process->description
                            ? Str::limit($process->description, 75)
                            : 'Sin descripción.' }}
                    </p>

                    <!-- Fecha -->
                    <small class="text-muted">
                        <i class="bi bi-clock me-1"></i>
                        {{ $process->updated_at->diffForHumans() }}
                    </small>
                </div>

                <!-- Acciones -->
                <div class="card-footer border-0 bg-transparent d-flex gap-2 pt-0">
                    <a href="{{ route('processes.show', $process) }}" class="btn btn-sm flex-fill" style="border-color: var(--color-primary); color: var(--color-primary);">
                        <i class="bi bi-eye me-1"></i>Ver
                    </a>
                    <a href="{{ route('processes.edit', $process) }}" class="btn btn-sm flex-fill text-white"
                       style="background-color: var(--color-primary); border-color: var(--color-primary);">
                        <i class="bi bi-pencil me-1"></i>Editar
                    </a>
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
        @endforeach
    </div>





    <!-- PAGINACION -->
    <div class="mt-5 d-flex flex-column align-items-center">
        <!-- texto manual en español (Este es el que se quedará) -->
        <div class="mb-3 text-muted small fw-medium">
            Mostrando {{ $processes->firstItem() }} a {{ $processes->lastItem() }} de {{ $processes->total() }} procesos
        </div>

        <nav aria-label="Navegación de procesos">
            {{ $processes->appends(request()->query())->links('pagination::bootstrap-4') }}
        </nav>
    </div>

@endif

@endsection