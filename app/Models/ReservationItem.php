<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book_reservation';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'reservation_id',
        'book_id',
        'status',
    ];

    protected $casts = [
        //
    ];

    public function scopeReservationId($query, $reservationId)
    {
        if ($reservationId)
            return $query->where('reservation_id', $reservationId);
    }


    public function scopeBookId($query, $bookId)
    {
        if ($bookId)
            return $query->where('book_id', $bookId);
    }

    public function scopeResNumber($query, $resNumber)
    {
        if ($resNumber)
            return $query->whereHas('reservation', function ($q) use ($resNumber) {
                    $q->where('res_number', 'ilike', "%{$resNumber}%");
                });
    }

    public function scopeMemberId($query, $memberId)
    {
        if ($memberId)
            return $query->whereHas('reservation', function ($q) use ($memberId) {
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
                    $q->whereHas('reservation', function ($q) use ($iniDate) {
                        $q->whereDate('res_date', '>=', $iniDate);
                    });

                })
                ->when($finDate, function ($q) use ($finDate) {
                    $q->whereHas('reservation', function ($q) use ($finDate) {
                        $q->whereDate('res_date', '<=', $finDate);
                    });
                });
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'reservation',
        'book',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
