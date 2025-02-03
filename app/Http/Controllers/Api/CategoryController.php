<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Interfaces\ICategoryRepository;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Categories",
 *     description="API per la gestione delle categorie"
 * )
 */
class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Lista delle categorie",
     *     description="Restituisce una lista di categorie paginata",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Numero della pagina",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista categorie restituita con successo",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Lista delle categorie recuperata con successo"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Category"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $category = $this->categoryRepository->getAll();
            return ApiResponse::success($category);
        } catch (\Exception $e) {
            return ApiResponse::error('Error', 500, $e);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Crea una nuova categoria",
     *     description="Crea una categoria e la salva nel database",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoria creata con successo",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Categoria creata con successo"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Category")
     *         )
     *     )
     * )
     */
    public function store(CategoryRequest $request)
    {
        try {
            $category = $this->categoryRepository->create($request->validated());
            return ApiResponse::success($category, "Categoria creata con successo", 201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500, $e);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Mostra una categoria",
     *     description="Restituisce i dettagli di una categoria specifica",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID della categoria",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria trovata con successo",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Singola categoria recuperata"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Category")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Categoria non trovata")
     * )
     */
    public function show($id)
    {
        try {
            $category = $this->categoryRepository->findById($id);
            return ApiResponse::success($category);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 404, $e);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Aggiorna una categoria",
     *     description="Modifica i dettagli di una categoria esistente",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID della categoria da aggiornare",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria aggiornata con successo",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Elemento modificato con successo"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Category")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Categoria non trovata")
     * )
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = $this->categoryRepository->update($id, $request->validated());
            return ApiResponse::success($category, "Categoria aggiornata con successo", 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 404, $e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Elimina una categoria",
     *     description="Rimuove una categoria dal database",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID della categoria da eliminare",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria eliminata con successo",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Elemento eliminato con successo"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Category")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Categoria non trovata")
     * )
     */
    public function destroy($id)
    {
        try {
            $category = $this->categoryRepository->delete($id);
            return ApiResponse::success($category, "Categoria eliminata con successo", 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 404, $e);
        }
    }
}
