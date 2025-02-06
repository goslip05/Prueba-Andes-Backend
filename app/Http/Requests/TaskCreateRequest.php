<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pendiente,en progreso,completada',
        ];
    }

    public function messages()
    {
        return [
            'title' => 'El Titulo es obligatorio',
            'title.string' => 'El Nombre debe ser una cadena de texto',
            'description.string' => 'La Descripción debe ser una cadena de texto',
            'due_date.required' => 'La fecha es obligatoria',
            'status' => 'El Estado es obligatorio',                    
            'status.in' => 'El Estado deber ser pendiente,en progreso o completada',                    
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
