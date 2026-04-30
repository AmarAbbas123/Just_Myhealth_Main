<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove old scattered fields
            $table->dropColumn([
                'user_type','first_name', 'last_name', 'dob', 'city', 'state', 'country',
                'business_name', 'contact_first_name', 'contact_last_name',
                'business_industry', 'business_sub_industry', 'business_type',
                'address1', 'address2', 'zip'
            ]);
    
            // Add new fields
            $table->unsignedTinyInteger('UserType')->default(1); // range 1–60
            $table->unsignedTinyInteger('AccountStatus')->default(0); // 0 = Pending
            $table->timestamp('UserCreatedTime')->nullable();
            $table->timestamp('UserActivatedTimeDate')->nullable();
            $table->unsignedTinyInteger('AccountFirstLogin')->default(0);
            $table->unsignedTinyInteger('AccountSetupComplete')->default(0);
    
            // Flexible profile data JSON
            $table->json('ProfileData')->nullable();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
