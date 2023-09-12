@extends('layouts.app')

@section('content')
    <div class="web2py_grid">
        <center><h5><b class="text-primary">Ficha del Libro</b></h5></center>

        <div class="d-flex justify-content-center">
            <div class="text-primary"><b>{{ 'Libro: ' . $book->code . ' - ' . $book->title }}</b>
            </div>

            <a class="button btn btn-secondary px-2 ml-5" href="#" onclick="history.back()" title="Volver a la página anterior">Volver</a>
        </div>

        <div class="d-flex justify-content-center table-responsive">
            <table class="table table-condensed table-striped table-bordered table-hover w-50 mt-2">
                <tbody>
                    <tr>
                        <td>Subtítulo</td>
                        <td>{{ $book->subtitle }}</td>
                    </tr>

                    <tr>
                        <td>Descripción</td>
                        <td>{{ $book->descrip }}</td>
                    </tr>

                    <tr>
                        <td>Autor</td>
                        <td>{{ $book->author }}</td>
                    </tr>

                    <tr>
                        <td>Edición</td>
                        <td>{{ $book->edition }}</td>
                    </tr>

                    <tr>
                        <td>Año de Publicación</td>
                        <td>{{ $book->pub_year }}</td>
                    </tr>

                    <tr>
                        <td>ISBN</td>
                        <td>{{ $book->isbn }}</td>
                    </tr>

                    <tr>
                        <td>Colección</td>
                        <td>{{ $book->collection->name }}</td>
                    </tr>

                    <tr>
                        <td>Editorial</td>
                        <td>{{ $book->publisher->fullName() }}</td>
                    </tr>

                    <tr>
                        <td>Encuadernación</td>
                        <td>{{ $book->binding }}</td>
                    </tr>

                    <tr>
                        <td>Cantidad de Páginas</td>
                        <td>{{ $book->page_count }}</td>
                    </tr>

                    <tr>
                        <td>Formato</td>
                        <td>{{ $book->format }}</td>

                    </tr>

                    <tr>
                        <td>Cantidad de Tomos</td>
                        <td>{{ $book->tome_count }}</td>
                    </tr>

                    <tr>
                        <td>Peso (g)</td>
                        <td>{{ $book->weight }}</td>
                    </tr>

                    <tr>
                        <td>Precio</td>
                        <td>{{ number_format($book->price, 2, ',', '.') }}</td>
                    </tr>

                    <tr>
                        <td>% Descuento</td>
                        <td>{{ number_format($book->disc_rate, 2, ',', '.') }}</td>
                    </tr>

                    <tr>
                        <td>% IVA</td>
                        <td>{{ number_format($book->ivaRate->value, 2, ',', '.') }}</td>
                    </tr>

                    <tr>
                        <td>Estado</td>
                        <td>{{ $book->status }}</td>
                    </tr>

                    <tr>
                        <td>Imagen</td>
                        <td align="center">
                            @if($book->image)
                                <img width="100px" src="/storage/{{ $book->image }}">
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
