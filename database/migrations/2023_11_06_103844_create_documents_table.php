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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('reference_num')->unique();
            $table->string('filetype',100);
            $table->string('doctype',9);
            $table->integer('volume');//Volume
            $table->string('records_medium',12);//Records Medium
            $table->string('records_location',30);//Records Location
            $table->string('restrictions',30);//Document Restrictions
            $table->text('path'); // Assuming path is for file storage
            $table->text('document'); // Assuming document is for file content
            $table->text('description')->nullable();//Description for the documents
            $table->date('inclusive_dates');
            $table->timestamp('due_date')->nullable();
            $table->integer('total_due')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};


