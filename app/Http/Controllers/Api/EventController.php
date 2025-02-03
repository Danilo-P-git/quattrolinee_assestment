<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Requests\SearchEventRequest;
use App\Repositories\Interfaces\IEventRepository;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Events",
 *     description="API per la gestione degli eventi"
 * )
 */
class EventController extends Controller
{
    protected $eventRepository;

    public function __construct(IEventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/events",
     *     summary="Lista degli eventi",
     *     description="Restituisce una lista di eventi paginati",
     *     tags={"Events"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Numero della pagina",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista eventi restituita con successo",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Lista degli eventi"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Event"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $events = $this->eventRepository->getAll();
            return ApiResponse::success($events);
        } catch (\Exception $e) {
            return ApiResponse::error('Error', 500, $e);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/events",
     *     summary="Crea un nuovo evento",
     *     description="Crea un evento e lo salva nel database",
     *     tags={"Events"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EventRequest")
     *     ),
     *      @OA\Response(
     *         response=201,
     *         description="Crea un evento e lo salva nel database",
     *         @OA\JsonContent(type="object",
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Creazione dell'evento"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Event")
     *          )
     *      )
     * )
     */
    public function store(EventRequest $request)
    {
        try {
            $event = $this->eventRepository->create($request->validated());
            return ApiResponse::success($event, "Evento creato con successo", 201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500, $e);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/events/{id}",
     *     summary="Mostra un evento",
     *     description="Restituisce i dettagli di un evento specifico",
     *     tags={"Events"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID dell'evento",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="Evento visualizzato con successo",
     *         @OA\JsonContent(type="object",
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Evento visualizzato"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Event")
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        try {
            $event = $this->eventRepository->findById($id);
            return ApiResponse::success($event);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 404, $e);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/events/{id}",
     *     summary="Aggiorna un evento",
     *     description="Modifica i dettagli di un evento esistente",
     *     tags={"Events"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID dell'evento da aggiornare",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EventRequest")
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="Evento modificato con successo",
     *         @OA\JsonContent(type="object",
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Evento modificato"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Event")
     *          )
     *      )
     * )
     */
    public function update(EventRequest $request, $id)
    {
        try {
            $event = $this->eventRepository->update($id, $request->validated());
            return ApiResponse::success($event, "Evento aggiornato con successo", 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 404, $e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/events/{id}",
     *     summary="Elimina un evento",
     *     description="Rimuove un evento dal database",
     *     tags={"Events"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID dell'evento da eliminare",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="Evento cancellato con successo",
     *         @OA\JsonContent(type="object",
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Evento cancellato"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Event")
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        try {
            $event = $this->eventRepository->delete($id);
            return ApiResponse::success($event, "Evento eliminato con successo", 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 404, $e);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/events/search",
     *     summary="Cerca e filtra eventi",
     *     description="Cerca eventi per nome o descrizione e filtra per categoria",
     *     tags={"Events"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Testo di ricerca per nome o descrizione",
     *         required=false,
     *         @OA\Schema(type="string", example="concerto")
     *     ),
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="Filtra per categoria",
     *         required=false,
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="Evento ricercato con successo",
     *         @OA\JsonContent(type="object",
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Evento ricercato con successo"),
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Event"))
     *          )
     *      )
     * )
     */
    public function search(SearchEventRequest $request)
    {
        try {
            $query = $request->query('q');
            $categoryId = $request->query('category_id');

            $events = $this->eventRepository->searchAndFilter($query, $categoryId);

            return ApiResponse::success($events, "Risultati della ricerca");
        } catch (\Exception $e) {
            return ApiResponse::error("Errore nella ricerca", 500, $e);
        }
    }
}
