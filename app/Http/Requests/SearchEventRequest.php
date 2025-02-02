<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SearchEventRequest",
 *     title="Ricerca Eventi",
 *     description="Schema per la ricerca e il filtraggio degli eventi",
 *     @OA\Property(
 *         property="q",
 *         type="string",
 *         description="Testo di ricerca per nome o descrizione",
 *         example="concerto"
 *     ),
 *     @OA\Property(
 *         property="category_id",
 *         type="integer",
 *         description="ID della categoria per il filtraggio",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="page",
 *         type="integer",
 *         description="Numero della pagina",
 *         example=1
 *     )
 * )
 */

class SearchEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permetti sempre l'accesso alla ricerca
    }

    public function rules(): array
    {
        return [
            'q' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'page' => 'nullable|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'q.string' => 'Il termine di ricerca deve essere una stringa.',
            'q.max' => 'Il termine di ricerca non può superare i 255 caratteri.',
            'category_id.integer' => 'L\'ID della categoria deve essere un numero intero.',
            'category_id.exists' => 'La categoria selezionata non esiste.',
            'page.integer' => 'Il numero della pagina deve essere un numero intero.',
            'page.min' => 'Il numero della pagina deve essere almeno 1.'
        ];
    }
}
