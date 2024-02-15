<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['name','description','image','price','category'];

    // protected $with = ['category_name'];
    protected $appends = ['categoryname'];
    protected $hidden = ['category_object'];

    public function categoryObject(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    public function getCategorynameAttribute()
    {
        return $this->categoryObject->name;
    }
    public function orders(): HasMany
    {
        return $this->hasMany(ProductOrder::class, 'product', 'id');
    }

}
