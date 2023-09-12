<div class="table-responsive">
    @if($loan->items()->count())
        @include('livewire.error-bag')

        <table class="table table-condensed table-striped table-bloaned table-hover">
            <thead>
                <tr>
                    <th style="text-align:center">Cód.Int.</th>
                    <th style="text-align:center">ISBN</th>
                    <th style="text-align:center">Título</th>
                    <th style="text-align:center">Autor</th>
                    <th style="text-align:center">Edición</th>
                    <th style="text-align:center">Editorial</th>
                    <th style="text-align:center">F.Vencim.</th>
                    @if(!$show)
                        <th style="text-align:center">Acción</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($loanItems as $item)
                    <tr>
                        <td align="center">{{ $item->book->code }}</td>
                        <td align="center">{{ $item->book->isbn }}</td>
                        <td nowrap="nowrap">{{ $item->book->title }}</td>
                        <td nowrap="nowrap">{{ $item->book->author }}</td>
                        <td align="center">{{ $item->book->edition }}</td>
                        <td nowrap="nowrap">{{ $item->book->publisher->name }}</td>
                        <td align="center">{{ $item->due_date->format('d/m/Y') }}</td>
                        @if(!$show)
                            <td align="center">
                                <a wire:click="removeBook({{ $item }})" wire:loading.attr="disabled" href="#" type="button" title="Elimina este Libro">
                                    <img src="{{ asset('images/icons8-basura-rojo.svg') }}" alt="Eliminar" width="30px">
                                </a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>