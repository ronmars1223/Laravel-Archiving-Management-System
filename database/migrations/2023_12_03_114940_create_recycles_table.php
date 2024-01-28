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
        Schema::create('recycles', function (Blueprint $table) {
            $table->id();
            $table->integer('reference_num')->unique();
            $table->string('filetype',60);
            $table->string('doctype',9);
            $table->integer('volume');//Volume
            $table->string('records_medium',12);//Records Medium
            $table->string('records_location',30);//Records Location
            $table->string('restrictions',30);//Document Restrictions
            $table->text('description')->nullable();//Description for the documents
            $table->timestamp('inclusive_dates');//Period covered
            $table->text('path'); // Assuming path is for file storage
            $table->text('document'); // Assuming document is for file content
            $table->timestamp('due_date')->nullable();
            $table->boolean('total_due')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recycles');
    }
};
