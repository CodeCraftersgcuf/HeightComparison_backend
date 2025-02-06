<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
   
    protected $fillable = ['category_id', 'name'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function fictionalSubcategories()
    {
        return $this->hasMany(FictionalSubcategory::class, 'subcategory_id');
    }

    public function celebrities()
    {
        return $this->hasMany(CelebrityData::class, 'subcategory_id');
    }

    public function fictionalCharacters()
    {
        return $this->hasMany(FictionalData::class, 'subcategory_id');
    }
}
