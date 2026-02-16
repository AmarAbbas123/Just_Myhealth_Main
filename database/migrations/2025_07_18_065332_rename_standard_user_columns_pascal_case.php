<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users CHANGE id ID BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");
        DB::statement("ALTER TABLE users CHANGE username UserName VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE users CHANGE email Email VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE users CHANGE pending_email PendingEmail VARCHAR(255) NULL");
        DB::statement("ALTER TABLE users CHANGE email_verified_at EmailVerifiedAt TIMESTAMP NULL");
        DB::statement("ALTER TABLE users CHANGE password Password VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE users CHANGE remember_token RememberToken VARCHAR(100) NULL");
        DB::statement("ALTER TABLE users CHANGE profile_photo_path ProfilePhotoPath VARCHAR(255) NULL");
        DB::statement("ALTER TABLE users CHANGE header_photo_path HeaderPhotoPath VARCHAR(255) NULL");
        DB::statement("ALTER TABLE users CHANGE created_at CreatedAt TIMESTAMP NULL");
        DB::statement("ALTER TABLE users CHANGE updated_at UpdatedAt TIMESTAMP NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users CHANGE ID id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");
        DB::statement("ALTER TABLE users CHANGE UserName username VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE users CHANGE Email email VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE users CHANGE PendingEmail pending_email VARCHAR(255) NULL");
        DB::statement("ALTER TABLE users CHANGE EmailVerifiedAt email_verified_at TIMESTAMP NULL");
        DB::statement("ALTER TABLE users CHANGE Password password VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE users CHANGE RememberToken remember_token VARCHAR(100) NULL");
        DB::statement("ALTER TABLE users CHANGE ProfilePhotoPath profile_photo_path VARCHAR(255) NULL");
        DB::statement("ALTER TABLE users CHANGE HeaderPhotoPath header_photo_path VARCHAR(255) NULL");
        DB::statement("ALTER TABLE users CHANGE CreatedAt created_at TIMESTAMP NULL");
        DB::statement("ALTER TABLE users CHANGE UpdatedAt updated_at TIMESTAMP NULL");
    }
};
