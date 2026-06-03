<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->backfillUsers();
        $this->backfillGroupClasses();
        $this->backfillTrainers();
        $this->backfillTrainerReviews();
        $this->backfillClubReviews();
        $this->backfillTrainerBookings();
        $this->backfillBookings();
    }

    public function down(): void
    {
        // Intentionally left empty.
        // This migration is a safe backfill for existing production databases.
    }

    private function backfillUsers(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['user', 'admin'])->default('user')->after('password');
            }

            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'tariff_id')) {
                $table->string('tariff_id')->nullable()->after('role');
            }

            if (!Schema::hasColumn('users', 'tariff_expires_at')) {
                $table->date('tariff_expires_at')->nullable()->after('tariff_id');
            }

            if (!Schema::hasColumn('users', 'active_promotion')) {
                $table->string('active_promotion')->nullable()->after('tariff_expires_at');
            }
        });
    }

    private function backfillGroupClasses(): void
    {
        if (!Schema::hasTable('group_classes')) {
            return;
        }

        Schema::table('group_classes', function (Blueprint $table) {
            if (!Schema::hasColumn('group_classes', 'days')) {
                $table->json('days')->nullable()->after('schedule');
            }
        });
    }

    private function backfillTrainers(): void
    {
        if (!Schema::hasTable('trainers')) {
            return;
        }

        Schema::table('trainers', function (Blueprint $table) {
            if (!Schema::hasColumn('trainers', 'methodology')) {
                $table->text('methodology')->nullable();
            }

            if (!Schema::hasColumn('trainers', 'achievements')) {
                $table->text('achievements')->nullable();
            }

            if (!Schema::hasColumn('trainers', 'price')) {
                $table->decimal('price', 10, 2)->nullable();
            }

            if (!Schema::hasColumn('trainers', 'rating')) {
                $table->decimal('rating', 2, 1)->default(5.0);
            }

            if (!Schema::hasColumn('trainers', 'clients_count')) {
                $table->integer('clients_count')->default(0);
            }

            if (!Schema::hasColumn('trainers', 'sessions_count')) {
                $table->integer('sessions_count')->default(0);
            }

            if (!Schema::hasColumn('trainers', 'formats')) {
                $table->string('formats')->nullable();
            }

            if (!Schema::hasColumn('trainers', 'image_url')) {
                $table->string('image_url')->nullable();
            }

            if (!Schema::hasColumn('trainers', 'education')) {
                $table->text('education')->nullable();
            }

            if (!Schema::hasColumn('trainers', 'instagram')) {
                $table->string('instagram')->nullable();
            }

            if (!Schema::hasColumn('trainers', 'telegram')) {
                $table->string('telegram')->nullable();
            }

            if (!Schema::hasColumn('trainers', 'training_format')) {
                $table->text('training_format')->nullable();
            }
        });
    }

    private function backfillTrainerReviews(): void
    {
        if (!Schema::hasTable('trainer_reviews')) {
            return;
        }

        Schema::table('trainer_reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('trainer_reviews', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('trainer_id');
            }

            if (!Schema::hasColumn('trainer_reviews', 'rating')) {
                $table->unsignedTinyInteger('rating')->default(5)->after('name');
            }

            if (!Schema::hasColumn('trainer_reviews', 'status')) {
                $table->string('status')->default('approved')->after('text');
            }

            if (!Schema::hasColumn('trainer_reviews', 'moderated_at')) {
                $table->timestamp('moderated_at')->nullable()->after('status');
            }

            if (!Schema::hasColumn('trainer_reviews', 'moderation_note')) {
                $table->text('moderation_note')->nullable()->after('moderated_at');
            }

            if (!Schema::hasColumn('trainer_reviews', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });

        if (Schema::hasColumn('trainer_reviews', 'created_at') && Schema::hasColumn('trainer_reviews', 'updated_at')) {
            DB::statement('UPDATE trainer_reviews SET updated_at = created_at WHERE updated_at IS NULL');
        }

        if (Schema::hasColumn('trainer_reviews', 'created_at') && Schema::hasColumn('trainer_reviews', 'moderated_at')) {
            DB::statement('UPDATE trainer_reviews SET moderated_at = created_at WHERE moderated_at IS NULL');
        }
    }

    private function backfillClubReviews(): void
    {
        if (!Schema::hasTable('club_reviews')) {
            return;
        }

        Schema::table('club_reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('club_reviews', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
            }

            if (!Schema::hasColumn('club_reviews', 'rating')) {
                $table->unsignedTinyInteger('rating')->default(5)->after('name');
            }

            if (!Schema::hasColumn('club_reviews', 'status')) {
                $table->string('status')->default('approved')->after('text');
            }

            if (!Schema::hasColumn('club_reviews', 'moderated_at')) {
                $table->timestamp('moderated_at')->nullable()->after('status');
            }

            if (!Schema::hasColumn('club_reviews', 'moderation_note')) {
                $table->text('moderation_note')->nullable()->after('moderated_at');
            }

            if (!Schema::hasColumn('club_reviews', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });

        if (Schema::hasColumn('club_reviews', 'created_at') && Schema::hasColumn('club_reviews', 'updated_at')) {
            DB::statement('UPDATE club_reviews SET updated_at = created_at WHERE updated_at IS NULL');
        }

        if (Schema::hasColumn('club_reviews', 'created_at') && Schema::hasColumn('club_reviews', 'moderated_at')) {
            DB::statement('UPDATE club_reviews SET moderated_at = created_at WHERE moderated_at IS NULL');
        }
    }

    private function backfillTrainerBookings(): void
    {
        if (!Schema::hasTable('trainer_bookings')) {
            return;
        }

        Schema::table('trainer_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('trainer_bookings', 'booking_time')) {
                $table->time('booking_time')->nullable()->after('booking_date');
            }
        });
    }

    private function backfillBookings(): void
    {
        if (!Schema::hasTable('bookings')) {
            return;
        }

        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'booking_time')) {
                $table->time('booking_time')->nullable()->after('booking_date');
            }
        });
    }
};
