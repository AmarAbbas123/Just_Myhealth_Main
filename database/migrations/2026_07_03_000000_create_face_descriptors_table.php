<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('face_descriptors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // 128-float face descriptor from face-api.js, stored as JSON array.
            $table->json('Descriptor');
            // How many camera samples were averaged to build this descriptor.
            $table->unsignedTinyInteger('SampleCount')->default(1);
            $table->timestamp('RegisteredAt')->useCurrent();
            $table->timestamps();

            $table->unique('user_id'); // one active face profile per user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('face_descriptors');
    }
};
