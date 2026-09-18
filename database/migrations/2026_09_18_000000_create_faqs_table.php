<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->text('Question');
            $table->longText('Answer');
            $table->integer('SortOrder')->default(0);
            $table->boolean('IsActive')->default(true);
            $table->timestamps();

            $table->index(['IsActive', 'SortOrder']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};