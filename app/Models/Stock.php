<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'book_id',
        'quantity',
        'location',
    ];

    public function scopeQuantity($query, $stock=true)
    {
        if ($stock)
            return $query->where('quantity', '>', 0);
    }

    public function scopeProvider($query, $providerId)
    {
        if ($providerId)
            return $query->whereHas('book.providers', function($query) use ($providerId) {
                    $query->where('providers.id', $providerId);
                });
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

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        //'book',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
