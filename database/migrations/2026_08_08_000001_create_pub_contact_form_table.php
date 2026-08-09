<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pub_contact_form', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->string('Email');
            $table->string('Subject');
            $table->text('Message');
            $table->string('FormLocation')->default('Main Contact Page');
            $table->string('Status')->default('New');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pub_contact_form');
    }
};
