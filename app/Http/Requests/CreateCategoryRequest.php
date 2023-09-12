<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $name = $this->method()=='PUT' ? ',name,' . $this->route('category')->id : '';

        return [
            'code' => ['nullable'], //['required', 'min:3', 'max:3', 'unique:categories' . $code],
            'name' => ['required', 'max:30', 'unique:categories' . $name],
            'descrip' => ['nullable', 'max:40'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            //'code.required' => 'Ingrese el Código de la Categoría',
            //'code.min' => 'El Código debe ser de 3 dígitos',
            //'code.max' => 'El Código debe ser de 3 dígitos',
            //'code.unique' => 'El Código ya existe',
            'name.required' => 'Ingrese el Nombre de la Categoría',
            'name.max' => 'La longitud máxima del Nombre es de 30 caracteres',
            'name.unique' => 'La Categoría ya existe',
            'descrip.max' => 'La longitud máxima de la Descripción es de 40 caracteres',
            'image.mimes' => 'Seleccione una imagen con extensión png, jpg, o jpeg',
            'image.max' => 'El tamaño máximo de la Imagen es de 2 MB',
        ];
    }
}
