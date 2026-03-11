<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        // Validación para que solo el autor pueda editar la noticia
        $news = $this->route('news');
        return auth()->check() && auth()->id() === $news->user_id;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        // Realizamos una pequeña validación para evitar problemas al validar campos únicos
        $newsId = $this->route('news')->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'section_id' => ['required', 'integer', 'exists:sections,id'],
            'status_id' => ['required', 'integer', 'exists:statuses,id'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'slug' => ['nullable', 'string', Rule::unique('news', 'slug')->ignore($newsId)],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'content.required' => 'El contenido es obligatorio.',
            'section_id.required' => 'Debes seleccionar una sección.',
            'section_id.exists' => 'La sección seleccionada no existe.',
            'status_id.required' => 'Debes seleccionar un estado.',
            'status_id.exists' => 'El estado seleccionado no existe.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'Formatos permitidos: jpg, jpeg, png, webp.',
            'image.max' => 'La imagen no puede superar 2MB.',
        ];
    }
}
