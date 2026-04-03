<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProcessRequest;
use App\Http\Requests\UpdateProcessRequest;
use App\Models\Process;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    /**
     * Listar todos los procesos con búsqueda opcional.
     */
    public function index(Request $request)
    {
        $query = Process::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $processes = $query->latest()->paginate(10);


        return view('processes.index', compact('processes'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('processes.create');
    }

    /**
     * Guardar nuevo proceso.
     */
    public function store(StoreProcessRequest $request)
    {
        Process::create($request->validated());

        return redirect()
            ->route('processes.index')
            ->with('success', 'Proceso creado correctamente.');
    }

    /**
     * Ver proceso en modo solo lectura.
     */
    public function show(Process $process)
    {
        return view('processes.show', compact('process'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Process $process)
    {
        return view('processes.edit', compact('process'));
    }

    /**
     * Actualizar proceso existente.
     */
    public function update(UpdateProcessRequest $request, Process $process)
    {
        $process->update($request->validated());

        return redirect()
            ->route('processes.index')
            ->with('success', 'Proceso actualizado correctamente.');
    }

    /**
     * Eliminar proceso.
     */
    public function destroy(Process $process)
    {
        $process->delete();

        return redirect()
            ->route('processes.index')
            ->with('success', 'Proceso eliminado correctamente.');
    }

    /**
     * Exportar el XML como archivo .bpmn
     */
    public function export(Process $process)
    {
        $filename = str($process->name)->slug()->append('.bpmn')->toString();

        return response($process->bpmn_xml, 200, [
            'Content-Type'        => 'application/xml',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}