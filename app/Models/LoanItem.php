<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book_loan';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'loan_id',
        'book_id',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date:Y-m-d',
    ];

    public function scopeLoanId($query, $loanId)
    {
        if ($loanId)
            return $query->where('loan_id', $loanId);
    }


    public function scopeBookId($query, $bookId)
    {
        if ($bookId)
            return $query->where('book_id', $bookId);
    }

    public function scopeLoanNumber($query, $loanNumber)
    {
        if ($loanNumber)
            return $query->whereHas('loan', function ($q) use ($loanNumber) {
                    $q->where('loan_number', 'ilike', "%{$loanNumber}%");
                });
    }

    public function scopeMemberId($query, $memberId)
    {
        if ($memberId)
            return $query->whereHas('loan', function ($q) use ($memberId) {
                $q->where('member_id', $memberId);
            });
    }

    public function scopeBookCode($query, $code)
    {
        if ($code)
            return $query->whereHas('book', function ($q) use ($code) {
                    $q->where('code', 'ilike', "%{$code}%");
                });
    }

    public function scopeIsbn($query, $isbn)
    {
        if ($isbn)
            return $query->whereHas('book', function ($q) use ($isbn) {
                    $q->where('isbn', 'ilike', "%{$isbn}%");
                });
    }

    public function scopeTitle($query, $title)
    {
        if ($title)
            return $query->whereHas('book', function ($q) use ($title) {
                    $q->where('title', 'ilike', "%{$title}%");
                });
    }

    public function scopeAuthor($query, $author)
    {
        if ($author)
            return $query->whereHas('book', function ($q) use ($author) {
                    $q->where('author', 'ilike', "%{$author}%");
                });
    }

    public function scopeDateRange($query, $iniDate, $finDate)
    {
        if ($iniDate or $finDate)
            return $query->when($iniDate, function ($q) use ($iniDate) {
                    $q->whereHas('loan', function ($q) use ($iniDate) {
                        $q->whereDate('due_date', '>=', $iniDate);
                    });

                })
                ->when($finDate, function ($q) use ($finDate) {
                    $q->whereHas('loan', function ($q) use ($finDate) {
                        $q->whereDate('due_date', '<=', $finDate);
                    });
                });
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        //
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
