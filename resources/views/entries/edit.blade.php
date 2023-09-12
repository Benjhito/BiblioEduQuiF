@extends("layouts.app")

@section("content")
    @livewire('entries.entry-create', [
        'book' => $book,
        'entry' => $entry,
        'prevQuant' => $entry->quantity,
        'update' => true,
    ])
@endsection
