<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CelebrityData extends Model
{
    protected $table = 'celebrity_data';

    protected $fillable = ['name', 'gender', 'height', 'category_id', 'subcategory_id', 'extras'];

    protected $casts = [
        'extras' => 'array', // Store extras as JSON
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
}
