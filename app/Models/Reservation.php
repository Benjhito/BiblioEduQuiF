<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'res_date',
        'res_number',
        'member_id',
        'status',
    ];

    protected $casts = [
        'res_date' => 'date:Y-m-d',
    ];

    public function scopeResDate($query, $resDate)
    {
        if ($resDate)
            return $query->whereDate('res_date', $resDate);
    }

    public function scopeMemberId($query, $memberId)
    {
        if ($memberId)
            return $query->where('member_id', $memberId);
    }

    public function scopeResNumber($query, $resNumber)
    {
        if ($resNumber)
            return $query->where('res_number', 'ilike', "%{$resNumber}%");
    }

    public function scopeLastName($query, $lastName)
    {
        if ($lastName)
            return $query->whereHas('member', function ($q) use ($lastName) {
                    $q->where('last_name', 'ilike', "%{$lastName}%");
                });
    }

    public function scopeMemberCode($query, $code)
    {
        if ($code)
            return $query->whereHas('member', function ($q) use ($code) {
                    $q->where('code', 'ilike', "%{$code}%");
                });
    }

    public function scopeStatus($query, $status)
    {
        if ($status)
            return $query->where('status', $status);
    }

    public function scopeDateRange($query, $iniDate, $finDate)
    {
        if ($iniDate or $finDate)
            return $query->when($iniDate, function ($q) use ($iniDate) {
                    $q->whereDate('res_date', '>=', $iniDate);
                })
                ->when($finDate, function ($q) use ($finDate) {
                    $q->whereDate('res_date', '<=', $finDate);
                });
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'member',
        'books',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_reservation') //->using(ReservationItem::class)
            ->withPivot('status');
            //->withTimestamps();
    }

    public function items()
    {
        return $this->hasMany(ReservationItem::class);
    }
}
