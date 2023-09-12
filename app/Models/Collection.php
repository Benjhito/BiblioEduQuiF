<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
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
        'descrip',
        'image',
    ];

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

    public function scopeDescrip($query, $descrip)
    {
        if ($descrip)
            return $query->where('descrip', 'ilike', "%{$descrip}%");
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
         //'books',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
