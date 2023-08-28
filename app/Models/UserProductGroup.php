<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProductGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "discount"
    ];

    public function groupItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductGroupItem::class, 'group_id');
    }
}
