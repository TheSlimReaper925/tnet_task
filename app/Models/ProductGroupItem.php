<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroupItem extends Model
{
    use HasFactory;

    protected $fillable = [
      "group_id",
      "product_id"
    ];

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'product_id', 'product_id');
    }

    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserProductGroup::class, 'group_id');
    }

    public function discountGroup() {
        return $this->belongsTo(UserProductGroup::class, 'group_id', 'group_id');
    }
}
