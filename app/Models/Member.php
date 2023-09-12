<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'last_name',
        'first_name',
        'doc_number',
        //'card_number',
        'address',
        'postcode',
        'locality',
        'mobile',
        'email',
        'adm_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'adm_date' => 'date:Y-m-d',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        //
    ];

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = mb_strtoupper($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = mb_strtoupper($value);
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = mb_strtoupper($value);
    }

    public function setLocalityAttribute($value)
    {
        $this->attributes['locality'] = mb_strtoupper($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = mb_strtolower($value);
    }

    public function scopeCode($query, $code)
    {
        if ($code)
            return $query->where('code', 'ilike', "%{$code}%");
    }

    public function scopeLastName($query, $lastName)
    {
        if ($lastName)
            return $query->where('last_name', 'ilike', "%{$lastName}%");
    }

    public function scopeDocNumber($query, $docNumber)
    {
        if ($docNumber)
            return $query->where('doc_number', 'ilike', "%{$docNumber}%");
    }

    public function scopeEmail($query, $email)
    {
        if ($email)
            return $query->where('email', 'ilike', "%{$email}%");
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 'Activo');
    }

    public function fullName()
    {
        return ucwords(mb_strtolower($this->last_name . ', ' . $this->first_name));
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        //
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'loans');
    }
}
