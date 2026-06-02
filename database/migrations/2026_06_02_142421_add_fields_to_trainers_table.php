<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
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

    public function down(): void
    {
        if (!Schema::hasTable('trainers')) {
            return;
        }

        Schema::table('trainers', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('trainers', 'methodology') ? 'methodology' : null,
                Schema::hasColumn('trainers', 'achievements') ? 'achievements' : null,
                Schema::hasColumn('trainers', 'price') ? 'price' : null,
                Schema::hasColumn('trainers', 'rating') ? 'rating' : null,
                Schema::hasColumn('trainers', 'clients_count') ? 'clients_count' : null,
                Schema::hasColumn('trainers', 'sessions_count') ? 'sessions_count' : null,
                Schema::hasColumn('trainers', 'formats') ? 'formats' : null,
                Schema::hasColumn('trainers', 'image_url') ? 'image_url' : null,
                Schema::hasColumn('trainers', 'education') ? 'education' : null,
                Schema::hasColumn('trainers', 'instagram') ? 'instagram' : null,
                Schema::hasColumn('trainers', 'telegram') ? 'telegram' : null,
                Schema::hasColumn('trainers', 'training_format') ? 'training_format' : null,
            ]);

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
