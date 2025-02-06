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
        Schema::create('fictional_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->decimal('height', 8, 2);
            $table->json('extras');
            $table->unsignedBigInteger('category_id'); // Foreign key from categories
            $table->unsignedBigInteger('subcat1_id');  // Foreign key from subcategories
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('subcat1_id')->references('id')->on('subcategories');
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
