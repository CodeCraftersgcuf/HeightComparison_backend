<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('celebrity_data', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the celebrity
            $table->string('gender'); // Gender as ENUM
            $table->string('height'); // Height with 2 decimal precision
            $table->bigInteger('category_id')->unsigned(); // Foreign key for category_id
            $table->bigInteger('subcategory_id')->nullable()->unsigned(); // Foreign key for subcategory_id
            $table->bigInteger('fictional_subcategory_id')->nullable()->unsigned(); // Foreign key for fictional_subcategory_id
            $table->timestamps(); // created_at and updated_at timestamps
            $table->json('extras');
            $table->string('category');
            $table->string('subCat1');
            $table->string('subCat2');
            // Foreign Key Constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->foreign('fictional_subcategory_id')->references('id')->on('fictional_subcategories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fictional_data');
    }
};
