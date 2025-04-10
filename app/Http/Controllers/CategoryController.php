<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Constructor - Aplicar middleware de autenticación excepto para index y show
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Mostrar listado de todas las categorías
     */
    public function index()
    {
        try {
            $categories = Category::all();

            return response()->json([
                'status' => 'success',
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener categorías',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Almacenar una nueva categoría
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string'
        ]);

        try {
            $category = Category::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Categoría creada exitosamente',
                'data' => $category
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear categoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar una categoría específica
     */
    public function show($id)
    {
        try {
            $category = Category::with('places')->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Categoría no encontrada',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Actualizar una categoría específica
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'string|max:255|unique:categories,name,'.$id,
            'description' => 'nullable|string'
        ]);

        try {
            $category = Category::findOrFail($id);
            $category->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Categoría actualizada exitosamente',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar categoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una categoría específica
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            // Verificar si hay lugares asociados
            if ($category->places()->count() > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se puede eliminar la categoría porque tiene lugares asociados'
                ], 409);
            }

            $category->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Categoría eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al eliminar categoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
