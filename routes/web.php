<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Books\BooksList;
use App\Http\Livewire\Loans\LoansList;
use App\Http\Livewire\Loans\LoanCreate;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Livewire\Stocks\StocksList;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\MemberController;
use App\Http\Livewire\Entries\EntriesList;
use App\Http\Livewire\Entries\EntryCreate;
use App\Http\Livewire\Members\MembersList;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DevolutionController;
use App\Http\Livewire\Providers\ProvidersList;
use App\Http\Controllers\ReservationController;
use App\Http\Livewire\Categories\CategoriesList;
use App\Http\Livewire\Publishers\PublishersList;
use App\Http\Livewire\Collections\CollectionsList;
use App\Http\Livewire\Devolutions\DevolutionsList;
use App\Http\Livewire\Devolutions\DevolutionCreate;
use App\Http\Livewire\Reservations\ReservationsList;
use App\Http\Livewire\Reservations\ReservationCreate;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function() {
    Route::get('members', MembersList::class);
    Route::get('members/index', MembersList::class)->name('members.index');
    Route::get('members/list', [MemberController::class, 'list'])->name('members.list');
    Route::get('members/export', [MemberController::class, 'export'])->name('members.export');

    Route::get('providers', ProvidersList::class);
    Route::get('providers/index', ProvidersList::class)->name('providers.index');
    Route::get('providers/list', [ProviderController::class, 'list'])->name('providers.list');
    Route::get('providers/export', [ProviderController::class, 'export'])->name('providers.export');

    Route::get('books', BooksList::class);
    Route::get('books/index', BooksList::class)->name('books.index');
    Route::get('books/list', [BookController::class, 'list'])->name('books.list');
    Route::get('books/export', [BookController::class, 'export'])->name('books.export');

    Route::get('publishers', PublishersList::class);
    Route::get('publishers/index', PublishersList::class)->name('publishers.index');
    Route::get('publishers/list', [PublisherController::class, 'list'])->name('publishers.list');
    Route::get('publishers/export', [PublisherController::class, 'export'])->name('publishers.export');

    Route::get('categories', CategoriesList::class);
    Route::get('categories/index', CategoriesList::class)->name('categories.index');
    Route::get('categories/list', [CategoryController::class, 'list'])->name('categories.list');
    Route::get('categories/export', [CategoryController::class, 'export'])->name('categories.export');

    Route::get('collections', CollectionsList::class);
    Route::get('collections/index', CollectionsList::class)->name('collections.index');
    Route::get('collections/list', [CollectionController::class, 'list'])->name('collections.list');
    Route::get('collections/export', [CollectionController::class, 'export'])->name('collections.export');

    Route::get('entries', EntriesList::class);
    Route::get('entries/index', EntriesList::class)->name('entries.index');
    Route::get('entries/create', EntryCreate::class)->name('entries.create');
    Route::get('entries/list', [EntryController::class, 'list'])->name('entries.list');
    Route::get('entries/export', [EntryController::class, 'export'])->name('entries.export');

    Route::get('loans', LoansList::class);
    Route::get('loans/index', LoansList::class)->name('loans.index');
    Route::get('loans/create', LoanCreate::class)->name('loans.create');
    Route::get('loans/list', [LoanController::class, 'list'])->name('loans.list');
    Route::get('loans/export', [LoanController::class, 'export'])->name('loans.export');

    Route::get('reservations', ReservationsList::class);
    Route::get('reservations/index', ReservationsList::class)->name('reservations.index');
    Route::get('reservations/create', ReservationCreate::class)->name('reservations.create');
    Route::get('reservations/list', [ReservationController::class, 'list'])->name('reservations.list');
    Route::get('reservations/export', [ReservationController::class, 'export'])->name('reservations.export');

    Route::get('devolutions', DevolutionsList::class);
    Route::get('devolutions/index', DevolutionsList::class)->name('devolutions.index');
    Route::get('devolutions/create', DevolutionCreate::class)->name('devolutions.create');
    Route::get('devolutions/list', [DevolutionController::class, 'list'])->name('devolutions.list');
    Route::get('devolutions/export', [DevolutionController::class, 'export'])->name('devolutions.export');

    Route::get('stocks/index', StocksList::class)->name('stocks.index');
    Route::get('stocks/list', [StockController::class, 'list'])->name('stocks.list');
    Route::get('stocks/export', [StockController::class, 'export'])->name('stocks.export');

    Route::resource('members', MemberController::class)->except(['index']);
    Route::resource('providers', ProviderController::class)->except(['index']);
    Route::resource('books', BookController::class)->except(['index']);
    Route::resource('publishers', PublisherController::class)->except(['index']);
    Route::resource('categories', CategoryController::class)->except(['index', 'show']);
    Route::resource('collections', CollectionController::class)->except(['index', 'show']);
    Route::resource('entries', EntryController::class)->only(['edit', 'destroy']);
    Route::resource('loans', LoanController::class)->only(['show', 'edit']);
    Route::resource('reservations', ReservationController::class)->only(['show', 'edit', 'destroy']);
    Route::resource('devolutions', DevolutionController::class)->only(['show', 'edit']);
});

