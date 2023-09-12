<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'loan_date',
        'loan_number',
        'member_id',
        'status',
    ];

    protected $casts = [
        'loan_date' => 'date:Y-m-d',
    ];

    public function scopeLoanDate($query, $loanDate)
    {
        if ($loanDate)
            return $query->whereDate('loan_date', $loanDate);
    }

    public function scopeMemberId($query, $memberId)
    {
        if ($memberId)
            return $query->where('member_id', $memberId);
    }

    public function scopeLoanNumber($query, $loanNumber)
    {
        if ($loanNumber)
            return $query->where('loan_number', 'ilike', "%{$loanNumber}%");
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
                    $q->whereDate('loan_date', '>=', $iniDate);
                })
                ->when($finDate, function ($q) use ($finDate) {
                    $q->whereDate('loan_date', '<=', $finDate);
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
        return $this->belongsToMany(Book::class, 'book_loan') //->using(LoanItem::class)
            ->withPivot('due_date');
            //->withTimestamps();
    }

    public function items()
    {
        return $this->hasMany(LoanItem::class);
    }
}
