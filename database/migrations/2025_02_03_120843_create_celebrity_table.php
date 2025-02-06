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
        Schema::create('celebrity', function (Blueprint $table) {
            $table->bigIncrements('id'); // Auto-incrementing BIGINT primary key
            $table->string('name'); // Name of the celebrity
            $table->enum('gender', ['m', 'f']); // Gender as ENUM
            $table->decimal('height', 5, 2); // Height with 2 decimal precision
            $table->bigInteger('category_id')->unsigned(); // Foreign key for category_id
            $table->bigInteger('subcategory_id')->nullable()->unsigned(); // Foreign key for subcategory_id
            $table->bigInteger('fictional_subcategory_id')->nullable()->unsigned(); // Foreign key for fictional_subcategory_id
            $table->timestamps(); // created_at and updated_at timestamps

            // Foreign Key Constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('set null');
            $table->foreign('fictional_subcategory_id')->references('id')->on('fictional_subcategories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('celebrity');
    }
};
