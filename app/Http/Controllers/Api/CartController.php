<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Event;
use App\Repositories\Interfaces\ICartRepository;

/**
 * @OA\Tag(
 *     name="Carts",
 *     description="API per la gestione dei carrelli e degli oggetti all'interno"
 * )
 */

class CartController extends Controller
{

    protected $cartRepository;

    public function __construct(ICartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }
    /**
     * @OA\Get(
     *     path="/api/carts/{cart_id}",
     *     summary="Lista degli item del carrello",
     *     description="Restituisce una lista degli item all'interno del carrello",
     *     tags={"Carts"},
     *     @OA\Parameter(
     *         name="cart_id",
     *         in="path",
     *         description="ID del carrello",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista degli item all'interno del carrello restituita con successo",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Lista degli oggetti all'interno del carrello"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/CartItem"))
     *         )
     *     )
     * )
     */
    public function show($cart_id)
    {
        try {
            $cart_item = $this->cartRepository->show($cart_id);

            return ApiResponse::success($cart_item);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500, $e);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/cart/add",
     *     summary="Aggiungi al cart un nuovo elemento",
     *     description="Aggiunge ad un cart (o lo crea) un singolo evento  ",
     *     tags={"Carts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CartRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoria creata con successo",
     *         @OA\JsonContent(ref="#/components/schemas/CartItem")
     *     )
     * )
     */
    public function add(CartRequest $request)
    {
        $cart_item = $this->cartRepository->addToCart($request);

        return ApiResponse::success($cart_item, 'evento aggiunto al carrello', 200);
    }
}
