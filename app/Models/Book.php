<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'title',
        'subtitle',
        'descrip',
        'author',
        'edition',
        'pub_year',
        'isbn',
        'collection_id',
        'publisher_id',
        'binding',
        'page_count',
        'format',
        'tome_count',
        'weight',
        //'stock',
        //'location',
        'price',
        'disc_rate',
        'iva_rate_id',
        'status',
        'image',
    ];

    protected $appends = [
        'cost',
        'amount',
    ];

    public function getCostAttribute()
    {
        $price = (float)$this->price;
        $discount = (float)$this->disc_rate;

        return $discount < 100 ? $price * (100 - $discount) / 100 : 0;
    }

    public function getAmountAttribute()
    {
        return (float)$this->cost * (int)$this->stock->quantity;
    }

    public function scopeCode($query, $code)
    {
        if ($code)
            return $query->where('code', 'ilike', "%{$code}%");
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

    public function scopeSubtitle($query, $subtitle)
    {
        if ($subtitle)
            return $query->where('subtitle', 'ilike', "%{$subtitle}%");
    }

    public function scopeDescrip($query, $descrip)
    {
        if ($descrip)
            return $query->where('descrip', 'ilike', "%{$descrip}%");
    }

    public function scopeAuthor($query, $author)
    {
        if ($author)
            return $query->where('author', 'ilike', "%{$author}%");
    }

    public function scopeProvider($query, $providerId)
    {
        if ($providerId)
            return $query->whereHas('providers', function($query) use ($providerId) {
                    $query->where('providers.id', $providerId);
                });
    }

    public function scopePublisher($query, $publisherId)
    {
        if ($publisherId)
            return $query->where('publisher_id', $publisherId);
    }

    public function scopeCategory($query, $categoryId)
    {
        if ($categoryId)
            return $query->whereHas('categories', function($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
    }

    public function scopeCollection($query, $collectionId)
    {
        if ($collectionId)
            return $query->where('collection_id', $collectionId);
    }

    public function scopeStock($query, $stock=false)
    {
        if ($stock)
            return $query->whereHas('stock', function ($q) {
                    $q->where('quantity', '>', 0);
                });
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        //'providers',
        //'categories',
        'collection',
        'publisher',
        'ivaRate',
        'stock',
    ];

    public function providers()
    {
        return $this->belongsToMany(Provider::class, 'book_provider');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function ivaRate()
    {
        return $this->belongsTo(IvaRate::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class)->withDefault([
                'quantity' => 0,
            ]);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'loans');
    }
}
