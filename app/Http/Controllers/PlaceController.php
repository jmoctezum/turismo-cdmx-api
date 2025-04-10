<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PlaceController extends Controller
{
    /**
     * Constructor - Aplicar middleware de autenticación excepto para índice y show
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'getByDistrict']]);
    }

    /**
     * Mostrar listado de todos los lugares
     */
    public function index(Request $request)
    {
        try {
            // Parámetros de paginación
            $perPage = $request->input('per_page', 15);
            $orderBy = $request->input('order_by', 'name');
            $order = $request->input('order', 'asc');

            // Filtros
            $query = Place::with('category');

            if ($request->has('category_id')) {
                $query->where('category_id', $request->input('category_id'));
            }

            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('district', 'like', "%{$search}%");
                });
            }

            $places = $query->orderBy($orderBy, $order)->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'data' => $places
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener lugares',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Almacenar un nuevo lugar
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'district' => 'required|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image_url' => 'nullable|url',
            'category_id' => 'required|exists:categories,id'
        ]);

        try {
            $place = Place::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Lugar creado exitosamente',
                'data' => $place
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear lugar',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un lugar específico
     */
    public function show($id)
    {
        try {
            $place = Place::with('category')->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $place
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lugar no encontrado',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Actualizar un lugar específico
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'string|max:255',
            'description' => 'string',
            'address' => 'string',
            'district' => 'string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image_url' => 'nullable|url',
            'category_id' => 'exists:categories,id'
        ]);

        try {
            $place = Place::findOrFail($id);
            $place->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Lugar actualizado exitosamente',
                'data' => $place
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar lugar',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un lugar específico
     */
    public function destroy($id)
    {
        try {
            $place = Place::findOrFail($id);
            $place->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Lugar eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al eliminar lugar',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener lugares por Alcaldía/municipio
     */
    public function getByDistrict($district)
    {
        try {
            $places = Place::with('category')
                ->where('district', 'like', "%{$district}%")
                ->orderBy('name')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $places
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener lugares por alcaldía',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
