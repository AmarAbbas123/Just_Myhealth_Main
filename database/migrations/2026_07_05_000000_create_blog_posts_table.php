<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('Title');
            $table->string('Slug')->unique();
            $table->string('Excerpt', 300); // short teaser shown on the blog grid
            $table->longText('Body');       // full post content (HTML)
            $table->string('FeaturedImagePath')->nullable();

            // Where this post came from, since these start as re-published
            // social media posts (Instagram/Facebook/Twitter/etc).
            $table->string('SourcePlatform')->nullable();
            $table->string('SourceUrl')->nullable();

            $table->boolean('IsPublished')->default(false);
            $table->timestamp('PublishedAt')->nullable();

            $table->foreignId('AuthorUserID')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['IsPublished', 'PublishedAt']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
