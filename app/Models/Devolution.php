<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolution extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'dev_date',
        'dev_number',
        'loan_id',
        'member_id',
        'status',
    ];

    protected $casts = [
        'dev_date' => 'date:Y-m-d',
    ];

    public function scopeDevolutionDate($query, $devolutionDate)
    {
        if ($devolutionDate)
            return $query->whereDate('dev_date', $devolutionDate);
    }

    public function scopeMemberId($query, $memberId)
    {
        if ($memberId)
            return $query->where('member_id', $memberId);
    }

    public function scopeDevNumber($query, $devNumber)
    {
        if ($devNumber)
            return $query->where('dev_number', 'ilike', "%{$devNumber}%");
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
                    $q->whereDate('dev_date', '>=', $iniDate);
                })
                ->when($finDate, function ($q) use ($finDate) {
                    $q->whereDate('dev_date', '<=', $finDate);
                });
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'loan',
        'member',
        'books',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_devolution')//->using(DevolutionItem::class)
            ->withPivot(['loan_id', 'status']);
            //->withTimestamps();
    }

    public function items()
    {
        return $this->hasMany(DevolutionItem::class);
    }
}
