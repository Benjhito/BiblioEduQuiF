<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'rec_date',
        'book_id',
        'book_code',
        'title',
        'isbn',
        'provider_id',
        'quantity',
        'missing',
        'surplus',
        'price',
        'disc_rate',
        'iva_rate_id',
    ];

    protected $casts = [
        'rec_date' => 'date:Y-m-d',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'cost',
        'amount'
    ];

    public function getCostAttribute()
    {
        $price = (float)$this->price;
        $discount = (float)$this->disc_rate;

        return $discount < 100 ? $price * (100 - $discount) / 100 : 0;
    }

    public function getAmountAttribute()
    {
        return $this->cost * ((int)$this->quantity - (int)$this->missing + (int)$this->surplus);
    }

    public function scopeBookCode($query, $bookCode)
    {
        if ($bookCode)
            return $query->where('book_code', 'ilike', "%{$bookCode}%");
    }

    public function scopeIsbn($query, $isbn)
    {
        if ($isbn)
            return $query->where('isbn', 'ilike', "%{$isbn}%");
    }

    public function scopeTitle($query, $title)
    {
        if ($title)
            return $query->where('title', 'ilike', "%{$title}%");
    }

    public function scopeProvider($query, $providerId)
    {
        if ($providerId)
            return $query->where('provider_id', $providerId);
    }

    public function scopePublisher($query, $publisherId)
    {
        if ($publisherId)
            return $query->whereHas('book', function ($q) use ($publisherId) {
                    $q->where('publisher_id', $publisherId);
                });
    }

    public function scopeCategory($query, $categoryId)
    {
        if ($categoryId)
            return $query->whereHas('book.categories', function($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
    }

    public function scopeCollection($query, $collectionId)
    {
        if ($collectionId)
            return $query->whereHas('book', function ($q) use ($collectionId) {
                    $q->where('collection_id', $collectionId);
                });
    }

    public function scopeDateRange($query, $iniDate, $finDate)
    {
        if ($iniDate or $finDate)
            return $query->when($iniDate, function ($q) use ($iniDate) {
                    $q->whereDate('rec_date', '>=', $iniDate);
                })
                ->when($finDate, function ($q) use ($finDate) {
                    $q->whereDate('rec_date', '<=', $finDate);
                });
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'book',
        'provider',
        'ivaRate',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function ivaRate()
    {
        return $this->belongsTo(IvaRate::class);
    }
}
