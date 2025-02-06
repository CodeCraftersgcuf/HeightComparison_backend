<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   protected $fillable=['name'];

   public function subcategory(){
    return $this->hasMany(Subcategory::class,'category_id');
   }
//    public function fictionalSubcategories()
//     {
//         return $this->hasMany(FictionalSubcategory::class,'category_id');
//     }

    public function celebrityData()
    {
        return $this->hasMany(CelebrityData::class,'category_id');
    }

    public function fictionalData()
    {
        return $this->hasMany(FictionalData::class,'category_id');
    }
}
