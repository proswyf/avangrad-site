<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password');
            $table->string('phone')->nullable()->after('email');
            $table->string('tariff_id')->nullable()->after('role');
            $table->date('tariff_expires_at')->nullable()->after('tariff_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'tariff_id', 'tariff_expires_at']);
        });
    }
};