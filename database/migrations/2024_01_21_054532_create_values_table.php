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
        Schema::create('values', function (Blueprint $table) {
            $table->id();
            $table->string('location',50)->nullable();
            $table->string('restrict',50)->nullable();
            $table->string('file',50)->nullable();
            $table->string('administrative',80)->nullable();
            $table->string('financial',80)->nullable();
            $table->string('legal',80)->nullable();
            $table->string('personnel',80)->nullable();
            $table->string('social',80)->nullable();
            $table->string('doc',20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('values');
    }
};
