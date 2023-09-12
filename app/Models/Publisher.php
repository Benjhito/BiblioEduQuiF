<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'name',
        'address',
        'postcode',
        'city',
        'state',
        'country',
        'phone',
        'email',
        'url',
        'logo',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtoupper($value);
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = mb_strtoupper($value);
    }

    public function setCityAttribute($value)
    {
        $this->attributes['city'] = mb_strtoupper($value);
    }

    public function setStateAttribute($value)
    {
        $this->attributes['state'] = mb_strtoupper($value);
    }

    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = mb_strtoupper($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = mb_strtolower($value);
    }

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = mb_strtolower($value);
    }

    public function scopeCode($query, $code)
    {
        if ($code)
            return $query->where('code', 'ilike', "%{$code}%");
    }

    public function scopeName($query, $name)
    {
        if ($name)
            return $query->where('name', 'ilike', "%{$name}%");
    }

    public function scopeEmail($query, $email)
    {
        if ($email)
            return $query->where('email', 'ilike', "%{$email}%");
    }

    public function scopeUrl($query, $url)
    {
        if ($url)
            return $query->where('url', 'ilike', "%{$url}%");
    }

    public function fullName()
    {
        return ucwords(mb_strtolower($this->name));
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        //
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
