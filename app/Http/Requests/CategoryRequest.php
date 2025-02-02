<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CategoryRequest",
 *     title="Richiesta di Creazione Categoria",
 *     description="Schema per la creazione e modifica delle categorie",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Rock")
 * )
 */

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Il nome dell\'evento è obbligatorio.',
            'name.string' => 'Il nome deve essere una stringa.',
            'name.max' => 'Il nome non può superare i 255 caratteri.',
        ];
    }
}
