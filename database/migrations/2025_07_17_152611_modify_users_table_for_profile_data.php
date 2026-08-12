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
        $oldColumns = [
            'user_type', 'first_name', 'last_name', 'dob', 'city', 'state', 'country',
            'business_name', 'contact_first_name', 'contact_last_name',
            'business_industry', 'business_sub_industry', 'business_type',
            'address1', 'address2', 'zip',
        ];

        $columnsToDrop = array_filter($oldColumns, fn ($column) => Schema::hasColumn('users', $column));
        if (! empty($columnsToDrop)) {
            Schema::table('users', function (Blueprint $table) use ($columnsToDrop) {
                $table->dropColumn($columnsToDrop);
            });
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'UserType')) {
                $table->unsignedTinyInteger('UserType')->default(1); // range 1–60
            }

            if (! Schema::hasColumn('users', 'AccountStatus')) {
                $table->unsignedTinyInteger('AccountStatus')->default(0); // 0 = Pending
            }

            if (! Schema::hasColumn('users', 'UserCreatedTime')) {
                $table->timestamp('UserCreatedTime')->nullable();
            }

            if (! Schema::hasColumn('users', 'UserActivatedTimeDate')) {
                $table->timestamp('UserActivatedTimeDate')->nullable();
            }

            if (! Schema::hasColumn('users', 'AccountFirstLogin')) {
                $table->unsignedTinyInteger('AccountFirstLogin')->default(0);
            }

            if (! Schema::hasColumn('users', 'AccountSetupComplete')) {
                $table->unsignedTinyInteger('AccountSetupComplete')->default(0);
            }

            if (! Schema::hasColumn('users', 'ProfileData')) {
                $table->json('ProfileData')->nullable();
            }
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
