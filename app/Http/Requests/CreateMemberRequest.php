<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateMemberRequest extends FormRequest
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
        $email = $this->method()=='PUT' ? ',email,' . $this->route('member')->id : '';

        return [
            'code' => ['nullable'], //['required', 'min:4', 'max:4'],
            'last_name' => ['required', 'max:30'],
            'first_name' => ['required', 'max:30'],
            'doc_number' => ['required', 'string', 'max:13'],
            'address' => ['nullable', 'string', 'max:50'],
            'postcode' => ['nullable', 'string', 'max:8'],
            'locality' => ['nullable', 'string', 'max:40'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255', 'unique:members' . $email],
            'adm_date' => ['required'],
            'status' => ['required', 'in:Activo,Suspendido'],
            'notes' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            //'code.required' => 'Ingrese el Número de Socio',
            //'code.min' => 'El Número de Socio debe tener 4 dígitos',
            //'code.max' => 'El Número de Socio debe tener 4 dígitos',
            'last_name.required' => 'Ingrese el Apellido del Socio',
            'last_name.max' => 'La longitud máxima del Apellido del Socio es de 30 caracteres',
            'first_name.required' => 'Ingrese el Nombre del Socio',
            'first_name.max' => 'La longitud máxima del Nombre del Socio es de 30 caracteres',
            'doc_number.required' => 'Ingrese el DNI',
            'address.max' => 'La longitud máxima del Domicilio es de 50 caracteres',
            'postcode.max' => 'La longitud máxima del Código Postal es de 8 caracteres',
            'locality.max' => 'La longitud máxima de la Localidad es de 40 caracteres',
            'mobile.max' => 'La longitud máxima del Tel. Móvil es de 20 dígitos',
            'email.max' => 'La longitud máxima del Email es de 255 caracteres',
            'email.unique' => 'El Email ya existe',
            'adm_date.required' => 'Ingrese la Fecha de Admisión',
            'status.required' => 'Ingrese el Estado del Socio',
        ];
    }
}
