<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('position');
            $table->text('bio')->nullable();
            $table->integer('experience')->comment('лет опыта');
            $table->text('specialization');
            $table->text('certificates')->nullable();
            $table->text('quote')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->text('methodology')->nullable();
            $table->text('achievements')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('rating', 2, 1)->default(5.0);
            $table->integer('clients_count')->default(0);
            $table->integer('sessions_count')->default(0);
            $table->string('formats')->nullable();
            $table->string('image_url')->nullable();
            $table->text('education')->nullable();
            $table->string('instagram')->nullable();
            $table->string('telegram')->nullable();
            $table->text('training_format')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainers');
    }
};
