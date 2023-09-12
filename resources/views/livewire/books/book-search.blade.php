<div>
    <input wire:model.debounce.500ms="search" type="text" name="search" style="width: 100%;" class="form-control" placeholder="Buscar Libro por Código|ISBN|Título|Autor..." autocomplete="off" autofocus="on" />

    @if(!empty($search))
        <div class="web2py_grid mt-2 w-75" style="background: #f2f3f4; overflow: auto; position: fixed; z-index: 99; border: 1px solid DeepSkyBlue;">
            <div class="web2py_console">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align:center">Cód.Int.</th>
                                <th style="text-align:center">ISBN</th>
                                <th style="text-align:center">Título</th>
                                <th style="text-align:center">Autor</th>
                                <th style="text-align:center">Edición</th>
                                <th style="text-align:center">Editorial</th>
                                <th style="text-align:center">Stock</th>
                                <th style="text-align:center">Precio</th>
                                <th style="text-align:center">%Desc.</th>
                                <th style="text-align:center">Costo</th>
                                <th style="text-align:center">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                                <tr>
                                    <td align="center">
                                        <a wire:click="selectBook({{ $book }})" href="#" title="Ingresa datos del Libro">
                                            {{ $book->code }}
                                        </a>
                                    </td>
                                    <td align="center">{{ $book->isbn }}</td>
                                    <td nowrap="nowrap">{{ substr($book->title, 0, 30) }}</td>
                                    <td nowrap="nowrap">{{ substr($book->author, 0, 30) }}</td>
                                    <td align="center">{{ $book->edition }}</td>
                                    <td nowrap="nowrap">{{ $book->publisher->name }}</td>
                                    <td align="center"><b>{{ $book->stock->quantity }}</b></td>
                                    <td align="right">{{ number_format($book->price, 2, ',', '.') }}</td>
                                    <td align="right">{{ number_format($book->disc_rate, 2, ',', '.') }}</td>
                                    <td align="right">{{ number_format($book->cost, 2, ',', '.') }}</td>
                                    <td align="right">{{ number_format($book->amount, 2, ',', '.') }}</td>
                                </tr>
                            @empty
                                @include("livewire.empty")
                            @endforelse
                        </tbody>
                    </table>

                    @if($books->count())
                        {{ $books->links('livewire.pagination') }}
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
