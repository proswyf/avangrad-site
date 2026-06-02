<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('trainer_reviews')) {
            Schema::create('trainer_reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('trainer_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('name');
                $table->unsignedTinyInteger('rating')->default(5);
                $table->text('text');
                $table->string('status')->default('pending');
                $table->timestamp('moderated_at')->nullable();
                $table->text('moderation_note')->nullable();
                $table->timestamps();

                $table->index(['trainer_id', 'status']);
                $table->index('status');
            });

            return;
        }

        Schema::table('trainer_reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('trainer_reviews', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('trainer_id')->constrained()->nullOnDelete();
            }

            if (!Schema::hasColumn('trainer_reviews', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
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
        });

        if (Schema::hasColumn('trainer_reviews', 'status')) {
            DB::table('trainer_reviews')
                ->whereNull('status')
                ->update(['status' => 'approved']);
        }

        if (Schema::hasColumn('trainer_reviews', 'created_at') && Schema::hasColumn('trainer_reviews', 'updated_at')) {
            DB::statement('UPDATE trainer_reviews SET updated_at = created_at WHERE updated_at IS NULL');
        }

        if (Schema::hasColumn('trainer_reviews', 'created_at') && Schema::hasColumn('trainer_reviews', 'moderated_at')) {
            DB::statement('UPDATE trainer_reviews SET moderated_at = created_at WHERE moderated_at IS NULL');
        }

        Schema::table('trainer_reviews', function (Blueprint $table) {
            $table->index(['trainer_id', 'status'], 'trainer_reviews_trainer_id_status_index');
            $table->index('status', 'trainer_reviews_status_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainer_reviews');
    }
};
