<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FictionalSubcategory extends Model
{
    protected $fillable = ['subcategory_id', 'name'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory1_id');
    }

    public function fictionalCharacters()
    {
        return $this->hasMany(FictionalData::class, 'fictional_subcategory_id');
    }
}
