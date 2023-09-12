<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePublisherRequest extends FormRequest
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
        $cond = $this->method()=='PUT';
        $name = $cond ? ',name,' . $this->route('publisher')->id : '';
        $email = $cond ? ',email,' . $this->route('publisher')->id : '';

        return [
            'code' => ['nullable'], //['required', 'min:3', 'max:3'],
            'name' => ['required', 'max:40', 'unique:publishers' . $name],
            'address' => ['nullable', 'string', 'max:50'],
            'postcode' => ['nullable', 'string', 'max:8'],
            'city' => ['nullable', 'string', 'max:40'],
            'state' => ['nullable', 'string', 'max:40'],
            'country' => ['nullable', 'string', 'max:40'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255', 'unique:publishers' . $email],
            'url' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            //'code.required' => 'Ingrese el Código de la Editorial',
            //'code.min' => 'El Código es de 3 dígitos',
            //'code.max' => 'El Código es de 3 dígitos',
            'name.required' => 'Ingrese el Nombre de la Editorial',
            'name.max' => 'La longitud máxima del Nombre de Editorial es de 40 caracteres',
            'name.unique' => 'El Nombre de Editorial ya existe',
            'address.max' => 'La longitud máxima de la Dirección es de 50 caracteres',
            'postcode.max' => 'La longitud máxima del Código Postal es de 8 caracteres',
            'city.max' => 'La longitud máxima de la Ciudad es de 40 caracteres',
            'state.max' => 'La longitud máxima del Estado es de 40 caracteres',
            'country.max' => 'La longitud máxima del País es de 40 caracteres',
            'phone.max' => 'La longitud máxima del Teléfono es de 20 caracteres',
            'email.max' => 'La longitud máxima del Email es de 255 caracteres',
            'email.unique' => 'El Email ya existe',
            'url.max' => 'La longitud máxima de la URL es de 255 caracteres',
            'image.mimes' => 'Seleccione una imagen con extensión png, jpg, o jpeg',
            'image.max' => 'El tamaño máximo de la Imagen es de 2 MB',
        ];
    }
}
