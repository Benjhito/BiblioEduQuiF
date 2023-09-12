<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProviderRequest extends FormRequest
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
        $name = $cond ? ',business_name,' . $this->route('provider')->id : '';
        $email = $cond ? ',email,' . $this->route('provider')->id : '';

        return [
            'code' => ['nullable'], //['required', 'min:3', 'max:3'],
            'business_name' => ['required', 'max:40', 'unique:providers' . $name],
            'address' => ['nullable', 'string', 'max:50'],
            'postcode' => ['nullable', 'string', 'max:8'],
            'locality' => ['nullable', 'string', 'max:40'],
            'province' => ['nullable', 'string', 'max:40'],
            'country' => ['nullable', 'string', 'max:40'],
            'phone1' => ['nullable', 'string', 'max:20'],
            'phone2' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255', 'unique:providers' . $email],
            'url' => ['nullable', 'string', 'max:255'],
            'acc_type' => ['required', 'in:CC,CA'],
            'acc_number' => ['nullable', 'string', 'max:15'],
            'cuit' => ['required', 'string', 'max:13'],
            'iva_type_id' => ['required', 'exists:iva_types,id'],
            //'inv_type' => ['required', 'string', 'max:1'],
            'inv_type' => ['required', 'in:A,B,C,X'],
            'contact' => ['nullable', 'string', 'max:30'],
        ];
    }

    public function messages()
    {
        return [
            //'code.required' => 'Ingrese el Código del Proveedor',
            //'code.min' => 'El código es de 3 dígitos',
            //'code.max' => 'El código es de 3 dígitos',
            'business_name.required' => 'Ingrese el Nombre del Proveedor',
            'business_name.max' => 'La longitud máxima del Nombre de Proveedor es de 40 caracteres',
            'business_name.unique' => 'El Nombre de Proveedor ya existe',
            'address.max' => 'La longitud máxima del Domicilio es de 50 caracteres',
            'postcode.max' => 'La longitud máxima del Código Postal es de 8 caracteres',
            'locality.max' => 'La longitud máxima de la Localidad es de 40 caracteres',
            'province.max' => 'La longitud máxima de la Provincia es de 40 caracteres',
            'country.max' => 'La longitud máxima del País es de 40 caracteres',
            'phone1.max' => 'La longitud máxima del Teléfono 1 es de 20 caracteres',
            'phone2.max' => 'La longitud máxima del Teléfono 2 es de 20 caracteres',
            'email.max' => 'La longitud máxima del Email es de 255 caracteres',
            'email.unique' => 'El Email ya existe',
            'url.max' => 'La longitud máxima de la URL es de 255 caracteres',
            'acc_type.max' => 'La longitud máxima del Tipo de Cuenta es de 20 caracteres',
            'acc_type.in' => 'Ingrese CC o CA para el Tipo de Cuenta',
            'acc_number.max' => 'La longitud máxima del Nro. de Cuenta es de 15 caracteres',
            'cuit.required' => 'Ingrese la CUIT del Proveedor',
            'cuit.max' => 'La longitud máxima de la CUIT es de 13 caracteres',
            'iva_type_id.required' => 'Seleccione el Tipo de IVA',
            'iva_type_id.exists' => 'El Tipo de IVA no existe en la Base de Datos',
            'inv_type.in' => 'Ingrese A, B, C, o X para el Tipo de Factura',
            'inv_type.required' => 'Ingrese el Tipo de Factura',
            'contact.max' => 'La longitud máxima del Contacto dentro de la Empresa es de 30 caracteres',
        ];
    }
}
