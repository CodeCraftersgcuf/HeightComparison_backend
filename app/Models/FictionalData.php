<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FictionalData extends Model
{
    protected $table = 'fictional_data';

    protected $fillable = ['name', 'gender', 'height', 'category_id', 'subcategory_id', 'fictional_subcategory_id', 'extras'];

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

    public function fictionalSubcategory()
    {
        return $this->belongsTo(FictionalSubcategory::class, 'fictional_subcategory_id');
    }
}
