<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'BPMN Empresarial')</title>
    

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/vennex_logo_nav.svg') }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/vennex_logo_nav.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/favicon-192.png') }}">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>

    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container d-flex align-items-end">
        <a class="navbar-brand fw-bold d-flex align-items-end gap-2" href="{{ route('processes.index') }}">
            <img src="{{ asset('images/vennex_logo.svg') }}" alt="Vennex Group" class="navbar-logo">
            <span> | BPMN Empresarial</span>
        </a>

        {{-- Solo visible en desktop --}}
        <div class="d-none d-lg-flex gap-2">
            <a href="{{ route('processes.create') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Nuevo Proceso
            </a>
        </div>
    </div>
</nav>

<!-- CONTENIDO -->
<main class="container py-4">

    @if(session('success'))
        <div class="alert alert-dismissible alert-auto-dismiss fade show border-0 shadow-sm"
             style="background-color: rgba(33,166,80,0.1); border-left: 4px solid var(--color-success) !important; border-radius: 0.5rem;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill" style="color: var(--color-success);"></i>
                <span style="color: var(--color-success);" class="fw-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-dismissible alert-auto-dismiss fade show border-0 shadow-sm"
             style="background-color: rgba(242,56,56,0.1); border-left: 4px solid var(--color-danger) !important; border-radius: 0.5rem;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-x-circle-fill" style="color: var(--color-danger);"></i>
                <span style="color: var(--color-danger);" class="fw-semibold">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<!-- BOTÓN FLOTANTE MÓVIL -->
<a href="{{ route('processes.create') }}" class="fab-new-process" title="Nuevo Proceso">
    <i class="bi bi-plus-lg"></i>
</a>

<!-- Modal Seguro deEliminar  -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="deleteModalLabel text-dark">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                <p class="mt-3 mb-0 fw-semibold">¿Estás seguro de que deseas eliminar este proceso?</p>
                <small class="text-muted">Esta acción no se puede deshacer.</small>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="color: var(--color-dark);">Cancelar</button>
                <button type="button" id="confirmDeleteBtn" class="btn px-4 text-white" style="background-color: var(--color-danger);">Eliminar Proceso</button>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <small>
        <i class="bi bi-diagram-3 me-1" style="color: var(--color-primary);"></i>
        BPMN Empresarial &copy; {{ date('Y') }} URN — Laravel 10 + bpmn-js 
    </small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<a href="{{ route('processes.create') }}" class="fab-new-process" title="Nuevo Proceso">+</a>

@vite(['resources/js/app.js'])
@stack('scripts')
</body>
</html>