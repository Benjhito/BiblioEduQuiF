<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'business_name',
        'address',
        'postcode',
        'locality',
        'province',
        'country',
        'phone1',
        'phone2',
        'email',
        'url',
        'acc_type',
        'acc_number',
        'cuit',
        'iva_type_id',
        'inv_type',
        'contact',
    ];

    public function setBusinessNameAttribute($value)
    {
        $this->attributes['business_name'] = mb_strtoupper($value);
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = mb_strtoupper($value);
    }

    public function setLocalityAttribute($value)
    {
        $this->attributes['locality'] = mb_strtoupper($value);
    }

    public function setProvinceAttribute($value)
    {
        $this->attributes['province'] = mb_strtoupper($value);
    }

    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = mb_strtoupper($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = mb_strtolower($value);
    }

    public function scopeBusinessName($query, $business_name)
    {
        if ($business_name)
            return $query->where('business_name', 'ilike', "%{$business_name}%");
    }

    public function scopeEmail($query, $email)
    {
        if ($email)
            return $query->where('email', 'ilike', "%{$email}%");
    }

    public function scopeCode($query, $code)
    {
        if ($code)
            return $query->where('code', 'ilike', "%{$code}%");
    }

    public function fullName()
    {
        return ucwords(mb_strtolower($this->business_name));
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'ivaType',
    ];

    public function ivaType()
    {
        return $this->belongsTo(IvaType::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_provider');
    }
}
