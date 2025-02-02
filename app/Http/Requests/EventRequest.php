<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        ];
    }
}
