<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
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
        $isbn = $this->method()=='PUT' ? ',isbn,' . $this->route('book')->id : '';

        return [
            'code' => ['nullable'], //['required', 'min:5', 'max:5', 'unique:books' . $code],
            'title' => ['required', 'string', 'max:100'],
            'subtitle' => ['nullable', 'string', 'max:200'],
            'descrip' => ['nullable', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:50'],
            'edition' => ['required', 'numeric', 'min:1'],
            'pub_year' => ['nullable', 'numeric', 'min:0'],
            'isbn' => ['nullable', 'string', 'max:20', 'unique:books' . $isbn],
            'categories' => ['sometimes', 'nullable', 'array', 'exists:categories,id'],
            'collection_id' => ['sometimes', 'nullable', 'exists:collections,id'],
            'publisher_id' => ['required', 'exists:publishers,id'],
            'binding' => ['nullable', 'string', 'max:20'],
            'page_count' => ['nullable', 'numeric', 'min:0'],
            'format' => ['nullable', 'string', 'max:20'],
            'tome_count' => ['nullable', 'numeric', 'min:1'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'disc_rate' => ['required', 'numeric', 'min:0'],
            'iva_rate_id' => ['required', 'exists:iva_rates,id'],
            'status' => ['required', 'in:Disponible,Prestado,Reservado'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            //'code.required' => 'Ingrese el Código del Libro',
            //'code.min' => 'El Código debe ser de 5 dígitos',
            //'code.max' => 'El Código debe ser de 5 dígitos',
            //'code.unique' => 'El Código del Libro ya existe',
            'title.required' => 'Ingrese el Título del Libro',
            'title.max' => 'La longitud máxima del Título del Libro es de 100 caracteres',
            'subtitle.max' => 'La longitud máxima del Subtítulo del Libro es de 200 caracteres',
            'descrip.max' => 'La longitud máxima de la Descripción del Libro es de 255 caracteres',
            'author.required' => 'Ingrese el Autor del Libro',
            'author.max' => 'La longitud máxima para el Autor del Libro es de 50 caracteres',
            'edition.required' => 'Ingrese la Edición del Libro',
            'pub_year.min' => 'El Año de Publicación no puede ser negativo',
            'isbn.unique' => 'El ISBN del Libro ya existe',
            'categories.exists' => 'Hay al menos una Categoría que no existe en la Base de Datos',
            'collection_id.exists' => 'La Colección no existe en la Base de Datos',
            'publisher_id.required' => 'Seleccione la Editorial del Libro',
            'publisher_id.exists' => 'La Editorial no existe en la Base de Datos',
            'binding.max' => 'La longitud máxima de la Encuadernación del Libro es de 20 caracteres',
            'page_count.min' => 'La Cantidad de Páginas no puede ser negativa',
            'format.max' => 'La longitud máxima del Formato del Libro es de 20 caracteres',
            'tome_count.min' => 'La Cantidad de Tomos no puede ser menor que 1',
            'weight.min' => 'El Peso del Libro no puede ser negativo',
            'price.required' => 'Ingrese el Precio del Libro',
            'price.min' => 'Ingrese un valor positivo para el Precio del Libro',
            'disc_rate.required' => 'Ingrese el Porcentaje de Descuento del Libro',
            'disc_rate.min' => 'El valor mímimo para el Porcentaje de Descuento es 0',
            'iva_rate_id.required' => 'Seleccione el % de IVA del Libro',
            'iva_rate_id.exists' => 'El Porcentaje de IVA no existe en la Base de Datos',
            'status.required' => 'Ingrese el Estado del Libro',
            'status.in' => 'Los valores permitidos para el Estado son Disponible, Prestado, y Reservado',
            'image.mimes' => 'Seleccione una imagen con extensión png, jpg, o jpeg',
            'image.max' => 'El tamaño máximo de la Imagen es de 2 MB',
        ];
    }
}
