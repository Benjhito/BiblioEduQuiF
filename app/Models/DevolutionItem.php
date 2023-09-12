<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevolutionItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book_devolution';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'devolution_id',
        'book_id',
        'loan_id',
        'status',
    ];

    protected $casts = [
        //
    ];

    public function scopeDevolutionId($query, $devolutionId)
    {
        if ($devolutionId)
            return $query->where('devolution_id', $devolutionId);
    }


    public function scopeBookId($query, $bookId)
    {
        if ($bookId)
            return $query->where('book_id', $bookId);
    }

    public function scopeDevNumber($query, $devNumber)
    {
        if ($devNumber)
            return $query->whereHas('devolution', function ($q) use ($devNumber) {
                    $q->where('dev_number', 'ilike', "%{$devNumber}%");
                });
    }

    public function scopeMemberId($query, $memberId)
    {
        if ($memberId)
            return $query->whereHas('devolution', function ($q) use ($memberId) {
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
                    $q->whereHas('devolution', function ($q) use ($iniDate) {
                        $q->whereDate('dev_date', '>=', $iniDate);
                    });

                })
                ->when($finDate, function ($q) use ($finDate) {
                    $q->whereHas('devolution', function ($q) use ($finDate) {
                        $q->whereDate('dev_date', '<=', $finDate);
                    });
                });
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'devolution',
        'loan',
        'book',
    ];

    public function devolution()
    {
        return $this->belongsTo(Devolution::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
