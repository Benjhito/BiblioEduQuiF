@if ($paginator->hasPages())
    <nav class="d-flex justify-content-end">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a href="javascript:;" wire:click="previousPage" class="page-link rounded px-2">&laquo;</a>
                </li>
            @else
                <li class="page-item">
                    <a href="javascript:;" wire:click="previousPage" rel="prev" class="page-link rounded px-2">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <a class="page-link rounded px-2">{{ $element }}</a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <a href="javascript:;" wire:click="gotoPage({{$page}})" class="page-link rounded pt-1 px-2">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="javascript:;" wire:click="gotoPage({{$page}})" class="page-link rounded pt-1 px-2">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="javascript:;" wire:click="nextPage" class="page-link rounded px-2">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <a href="javascript:;" class="page-link rounded px-2">&raquo;</a>
                </li>
            @endif
        </ul>
    </nav>
@endif
