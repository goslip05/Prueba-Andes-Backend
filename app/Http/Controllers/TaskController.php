<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskCollection;
use Illuminate\Http\Request;
use App\Models\Task; // Asegúrate de importar el modelo de Task
use Illuminate\Support\Facades\Validator;
use App\Mail\HighPriorityTaskNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Task::query();

            // Filtrar por usuario
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            // Filtrar por estado 
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
    
            // Filtrar por prioridad 
            if ($request->has('title')) {
                $query->where('title', $request->title);
            }
    
            return new TaskCollection($query->paginate(5));

        } catch (\Throwable $th) {
            Log::info('Error la visualizacion de la tareas :' . $th);
            return response()->json($th, 500);
        }
       
    }

    public function store(TaskCreateRequest $request)
    {
        try {

            // Crear una nueva tarea
            $task = auth()->user()->tasks()->create($request->validated());
            return response()->json($task, 201);

        } catch (\Throwable $th) {
            return response()->json($th, 422);
        }
    }

    public function update(TaskUpdateRequest $request, $id)
    {
        try {
            // Obtener el usuario
            $user = auth()->user();

            // bsucar la tarea en la DB
            $task = Task::find($id);

            if (!$task) {
                return response()->json(['error' => 'Tarea no encontrada'], 404);
            }

            //validacion de roles
            if (!$user->hasRole('admin') && $task->user_id != $user->id) {
                return response()->json(['error' => 'No tienes permisos para editar esta tarea'], 403);
            }

            $task->update($request->validated());
            return response()->json($task);

        } catch (\Throwable $th) {
            Log::info('Error tarea actualizada :' . $th);
            return response()->json($th, 500);
        }
    }

    public function delete($id)
    {
        try {
            // Obtener el usuario
            $user = auth()->user();

            // buscar la tarea en la DB
            $task = Task::find($id);

            if (!$task) {
                return response()->json(['error' => 'Tarea no encontrada'], 404);
            }

            //validacion de roles
            if (!$user->hasRole('admin') && $task->user_id != $user->id) {
                return response()->json(['error' => 'No tienes permisos para eliminar esta tarea'], 403);
            }

            $task->delete();
            return response()->json(['message' => 'Tarea eliminada exitosamente']);

        } catch (\Throwable $th) {
            Log::info('Error al eliminar la tarea :' . $th);
            return response()->json($th, 500);
        }
    }

    public function show($id)
    {
        try {

            // buscar la tarea en la DB
            $task = Task::find($id);

            return response()->json($task);

        } catch (\Throwable $th) {
            Log::info('Error al mostrar la tarea :' . $th);
            return response()->json($th, 500);
        }
    }
}
