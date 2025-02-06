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
        Schema::create('avatars_endomorphs', function (Blueprint $table) {
            $table->id();
            $table->string('E_id');
            $table->foreignId('avatar_id')->constrained('avatars', 'id');
            $table->string('name');
            $table->integer('adjustPosition');
            $table->boolean('isFrozen');
            $table->string('link');
            $table->json('type');
            $table->json('parameters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avatars_endomorphs');
    }
};
