<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="EventRequest",
 *     required={"name", "description", "length", "start_date"},
 *     @OA\Property(property="name", type="string", example="Concerto Jazz"),
 *     @OA\Property(property="description", type="string", example="Concerto jazz dal vivo"),
 *     @OA\Property(property="length", type="number", format="float", example=3.0),
 *     @OA\Property(property="start_date", type="string", format="date-time", example="2024-07-15 21:00:00"),
 *     @OA\Property(property="category_id", type="integer", example=2),
 *     @OA\Property(property="available_tickets", type="integer", example=1),
 * )
 */

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cambia a true se vuoi che sia sempre autorizzato
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'length' => 'required|numeric|min:0',
            'start_date' => 'required|date|after:today',
            'category_id' => 'nullable|integer|exists:categories,id',
            'available_tickets' => 'required|integer|min:1',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Il nome dell\'evento è obbligatorio.',
            'name.string' => 'Il nome deve essere una stringa.',
            'name.max' => 'Il nome non può superare i 255 caratteri.',

            'description.required' => 'La descrizione è obbligatoria.',
            'description.string' => 'La descrizione deve essere una stringa.',

            'length.required' => 'La durata è obbligatoria.',
            'length.numeric' => 'La durata deve essere un numero.',
            'length.min' => 'La durata deve essere almeno 0.',

            'start_date.required' => 'La data di inizio è obbligatoria.',
            'start_date.date' => 'La data di inizio deve essere una data valida.',
            'start_date.after' => 'La data di inizio deve essere futura.',

            'category_id.integer' => 'L\'ID della categoria deve essere un numero intero.',
            'category_id.exists' => 'La categoria selezionata non esiste.',

            'available_tickets.integer' => 'Il numero di biglietti deve essere un numero intero',
            'available_tickets.min' => 'Il numero di biglietti deve essere un numero maggiore di 0'
        ];
    }
}
