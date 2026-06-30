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
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable();
            $table->string('avatar')->nullable();
            $table->string('password')->nullable()->change(); //password boleh null jika login menggunakan google

            $table->string('otp_code')->nullable()->after('avatar');
            $table->timestamp('otp_expired_at')->nullable()->after('otp_code');
            $table->boolean('otp_verified')->default(false)->after('otp_expired_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar', 'otp_code', 'otp_expired_at', 'otp_verified']);
        });
    }
};
