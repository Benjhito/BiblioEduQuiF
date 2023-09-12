<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Exports\StocksExport;
use App\Exports\StocksListPdf;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    public function list(StocksListPdf $pdf)
    {
        $title = 'Inventario';
        $line = str_repeat('-', 89);
        $pdf->AliasNbPages();
        $pdf->SetMargins(12, 15);
        $pdf->AddPage('P', 'A4');
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Benjamin Emanuel Tito');
        $pdf->SetCreator('Benjamin Emanuel Tito');
        $pdf->SetSubject($title);

        $nTotCst = 0;
        $search = session()->get('search-7.1');

        $stocks = Stock::quantity()
            ->join('books', 'stocks.book_id', '=', 'books.id')
            ->select('stocks.*')
            ->where(function ($query) use ($search) {
                $query->where('books.code', 'ilike', "%{$search}%")
                      ->orWhere('books.isbn', 'ilike', "%{$search}%")
                      ->orWhere('books.title', 'ilike', "%{$search}%")
                      ->orWhere('books.author', 'ilike', "%{$search}%")
                      ->provider(session()->get('providerId-7.1'))
                      ->publisher(session()->get('publisherId-7.1'))
                      ->category(session()->get('categoryId-7.1'))
                      ->collection(session()->get('collectionId-7.1'));
            })
            ->orderBy('books.title')
            ->get();

        foreach ($stocks as $stock) {
            $row = $stock->book->code . '  ' .
                str_pad(substr($stock->book->isbn, 0, 12), 14, ' ') .
                str_pad(substr($stock->book->title, 0, 25), 26, ' ') .
                str_pad($stock->quantity, 4, ' ', STR_PAD_LEFT) . '   ' .
                str_repeat('_', 5) .
                str_pad(number_format($stock->book->price, 2, ',', '.'), 10, ' ', STR_PAD_LEFT) .
                str_pad(number_format($stock->book->disc_rate, 2, ',', '.'), 8, ' ', STR_PAD_LEFT) .
                //str_pad(number_format($stock->book->ivaRate->value, 2, ',', '.'), 8, ' ', STR_PAD_LEFT) .
                str_pad(number_format($stock->book->cost, 2, ',', '.'), 10, ' ', STR_PAD_LEFT) .
                str_pad(number_format($stock->book->amount, 2, ',', '.'), 12, ' ', STR_PAD_LEFT);
            $pdf->Cell(0, 5, $row, 0, 1);

            $nTotCst += $stock->book->amount;
        }

        $pdf->SetFont('Courier', '', 10);
        $pdf->Cell(0, 3, $line, 0, 1);
        $pdf->SetFont('Courier', 'B', 10);
        $pdf->Cell(0, 5, 'Stock Valorizado: ' . str_pad(number_format( $nTotCst, 2, ',', '.'), 71, ' ', STR_PAD_LEFT), 0, 1);
        $pdf->SetFont('Courier', '', 10);
        $pdf->Cell(0, 3, $line, 0, 1);

        return response($pdf->output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-disposition', 'filename=ListadoStock(' . now()->format('d-m-Y') . ').pdf');
    }

    public function export(StocksExport $stocksExport)
    {
        return Excel::download($stocksExport, 'ListadoStock(' . now()->format('d-m-Y') . ').xlsx');
    }
}
