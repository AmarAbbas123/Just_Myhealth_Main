<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('BlogPostID')->constrained('blog_posts')->cascadeOnDelete();
            $table->unsignedBigInteger('UserID');
            $table->longText('Comment');
            $table->timestamps();

            $table->foreign('UserID')->references('ID')->on('users')->cascadeOnDelete();
            $table->index(['BlogPostID', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_comments');
    }
};
