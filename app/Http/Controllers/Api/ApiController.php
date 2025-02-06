<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\Category;
use App\Models\CelebrityData;
use App\Models\Entity;
use App\Models\FictionalData;
use App\Models\FictionalSubcategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function entities(){
        $entities = Entity::where('isFrozen', false)->get();
        return response()->json([
            'status' => true,
            'entities' => $entities,
           'message' => 'Entities retrieved successfully'
        ]);
    }
    public function avatar_ectomorph(){
        $Avatar = Avatar::with('ectomorph')->get();
        return response()->json([
            'status' => true,
            'ectomorph' => $Avatar,
           'message' => 'Avatar_ectomorph retrieved successfully'
        ]);
    }
    public function avatar_endomorph(){
        $Avatar = Avatar::with('endomorph')->get();
        return response()->json([
            'status' => true,
            'endomorph' => $Avatar,
           'message' => 'avatar_endomorph retrieved successfully'
        ]);
    }
    public function avatar_mesomorph(){
        $Avatar = Avatar::with('mesomorph')->get();
        return response()->json([
            'status' => true,
            'mesomorph' => $Avatar,
           'message' => 'Avatar_mesomorph retrieved successfully'
        ]);
    }

    // Categories

    public function categories(){
        $categories = Category::all();
        return response()->json([
           'status' => true,
            'categories' => $categories,
           'message' => 'Categories retrieved successfully'
        ]);
    }
    public function subcategories($categoryId){
        $category = Category::findOrFail($categoryId);
        $subcategoris = Subcategory::where('category_id',$categoryId)->get();

        return response()->json([
           'status' => true,
           'category_detail' =>$category,
           'subcategories' => $subcategoris,
           'message' => 'Subcategories retrieved successfully'
        ]);
    }

    public function fictionalSubcategory($subcategoryId){
        $subcategory = Subcategory::findOrFail($subcategoryId);
        $fictionalSubcategory = FictionalSubcategory::where('subcategory1_id',$subcategoryId)->get();
        return response()->json([
           'status' => true,
           'subcategory_detail' => $subcategory,
            'fictionalSubcategories' => $fictionalSubcategory,
           'message' => 'Fictional subcategories retrieved successfully'
        ]);
    }

    public function celebrity_data($subcategoryId){
        $celebrityData = CelebrityData::where('subcategory_id',$subcategoryId)->get();
      $subcategory =  Subcategory::find($subcategoryId);
        return response()->json([
           'status' => true,
           'subcategory_detail' => $subcategory ,
            'celebrity_data' => $celebrityData,
           'message' => 'Celebrity data retrieved successfully'
        ]);
    }
    public function fictional_data($fictionalsubcategoryId){
        $celebrityData = FictionalData::where('fictional_subcategory_id',$fictionalsubcategoryId)->get();
      $subcategory =  FictionalSubcategory::find($fictionalsubcategoryId);
        return response()->json([
           'status' => true,
           'fictional_subcategory_detail' => $subcategory ,
            'fictional_data' => $celebrityData,
           'message' => 'Fictional data retrieved successfully'
        ]);
    }
}
