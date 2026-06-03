<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('trainer_bookings') || Schema::hasColumn('trainer_bookings', 'booking_time')) {
            return;
        }

        Schema::table('trainer_bookings', function (Blueprint $table) {
            $table->time('booking_time')->nullable()->after('booking_date');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('trainer_bookings') || !Schema::hasColumn('trainer_bookings', 'booking_time')) {
            return;
        }

        Schema::table('trainer_bookings', function (Blueprint $table) {
            $table->dropColumn('booking_time');
        });
    }
};
