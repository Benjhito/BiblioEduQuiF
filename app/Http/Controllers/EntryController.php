<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Entry;
use App\Models\Stock;
use App\Exports\EntriesExport;
use App\Exports\EntriesListPdf;
use Maatwebsite\Excel\Facades\Excel;

class EntryController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entry $entry)
    {
        $book = Book::findOrFail($entry->book_id);

        return view('entries.edit', compact('book', 'entry'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {
        $stock = Stock::where('book_id', $entry->book_id)->first();

        if ($stock) {
            $quantity = $stock->quantity - $entry->quantity;
            $stock->update(['quantity' => $quantity]);
        } else {
            return back()->withErrors('No se pudo actualizar la tabla de Stock.');
        }

        $entry->delete();

        return redirect()->route('entries.index')->withSuccess('¡El Ingreso fue eliminado de la Base de Datos!');
    }

    public function list(EntriesListPdf $pdf)
    {
        $title = 'Listado de Ingresos';
        $line = str_repeat('-', 97);
        $pdf->AliasNbPages();
        $pdf->SetMargins(12, 15);
        $pdf->AddPage('P', 'A4');
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Benjamin Emanuel Tito');
        $pdf->SetCreator('Benjamin Emanuel Tito');
        $pdf->SetSubject($title);

        $prev_code = '';
        $flag = false;
        $head = true;
        $nTotEjs = $nTotCst = $nTotTit = $nSubTotEjs = $nSubTotCst = $nSubTotTit = 0;

        $search = session()->get('search-4.2');

        $entries = Entry::bookCode($search)
            ->orWhere->isbn($search)
            ->orWhere->title($search)
            ->provider(session()->get('providerId-4.2'))
            ->publisher(session()->get('publisherId-4.2'))
            ->category(session()->get('categoryId-4.2'))
            ->collection(session()->get('collectionId-4.2'))
            ->dateRange(session()->get('iniDate-4.2'), session()->get('finDate-4.2'))
            ->orderBy('provider_id')
            ->orderBy('rec_date', 'desc')
            ->orderBy('title')
            ->get();

        foreach ($entries as $entry) {
            $provider_id = $entry->provider_id;
            $provider = utf8_decode($entry->provider->business_name);

            if ($head) {
                $pdf->SetFont('Courier', 'B', 9);
                $pdf->Cell(0, 5, $provider, 0, 1);
                $pdf->SetFont('Courier', '', 9);
                $pdf->Cell(0, 3, $line, 0, 1);
                $head = false;
            }

            if ($flag and $provider_id != $prev_code) {
                $pdf->Cell(0, 3, $line, 0, 1);
                $pdf->Cell(0, 5, 'Cant. Libros del Proveedor: ' . str_pad((string)$nSubTotTit, 5, ' ', STR_PAD_LEFT) . str_pad((string)$nSubTotEjs, 14, ' ', STR_PAD_LEFT) . str_pad((string)number_format($nSubTotCst, 2, ',', '.'), 50, ' ', STR_PAD_LEFT), 0, 1);
                $pdf->Cell(0, 3, $line, 0, 1);
                $pdf->SetFont('Courier', 'B', 9);
                $pdf->Cell(0, 5, $provider, 0, 1);
                $pdf->SetFont('Courier', '', 9);
                $pdf->Cell(0, 3, $line, 0, 1);
                $nSubTotEjs = $nSubTotCst = $nSubTotTit = 0;
            }

            $row = $entry->rec_date->format('d/m/y') . '  ' .
                $entry->book_code . '  ' .
                str_pad(substr($entry->title, 0, 28), 29, ' ') .
                str_pad($entry->quantity, 4, ' ', STR_PAD_LEFT) .
                str_pad($entry->missing, 4, ' ', STR_PAD_LEFT) .
                str_pad($entry->surplus, 3, ' ', STR_PAD_LEFT) .
                str_pad(number_format($entry->price, 2, ',', '.'), 10, ' ', STR_PAD_LEFT) .
                str_pad(number_format($entry->disc_rate, 2, ',', '.'), 6, ' ', STR_PAD_LEFT) .
                //str_pad(number_format($entry->book->ivaRate->value, 2, ',', '.'), 8, ' ', STR_PAD_LEFT) .
                str_pad(number_format( $entry->cost, 2, ',', '.'), 10, ' ', STR_PAD_LEFT) .
                str_pad(number_format( $entry->amount, 2, ',', '.'), 14, ' ', STR_PAD_LEFT);
            $pdf->Cell(0, 4, $row, 0, 1);

            $nSubTotEjs += $entry->quantity;
            $nSubTotCst += $entry->amount;
            $nSubTotTit += 1;
            $nTotEjs += $entry->quantity;
            $nTotCst += $entry->amount;
            $nTotTit += 1;
            $prev_code = $provider_id;
            $flag = true;
        }

        $pdf->Cell(0, 3, $line, 0, 1);
        $pdf->Cell(0, 5, 'Cant. Libros del Proveedor: ' . str_pad((string)$nSubTotTit, 5, ' ', STR_PAD_LEFT) . str_pad((string)$nSubTotEjs, 14, ' ', STR_PAD_LEFT) . str_pad(number_format($nSubTotCst, 2, ',', '.'), 50, ' ', STR_PAD_LEFT), 0, 1);
        $pdf->Cell(0, 3, $line, 0, 1);
        $pdf->SetFont('Courier', 'B', 9);
        $pdf->Cell(0, 5, 'Cant. Total de Libros: ' . str_pad((string)$nTotTit, 10, ' ', STR_PAD_LEFT) . str_pad((string)$nTotEjs, 14, ' ', STR_PAD_LEFT) . str_pad(number_format($nTotCst, 2, ',', '.'), 50, ' ', STR_PAD_LEFT), 0, 1);

        return response($pdf->output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-disposition', 'filename=ListadoIngresos(' . now()->format('d-m-Y') . ').pdf');
    }

    public function export(EntriesExport $entriesExport)
    {
        return Excel::download($entriesExport, 'Ingresos(' . now()->format('d-m-Y') . ').xlsx');
    }
}
