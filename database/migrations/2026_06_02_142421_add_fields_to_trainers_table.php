<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
            $table->string('position')->after('slug');
            $table->string('bio')->after('position');
            $table->integer('experience')->after('bio')->comment('лет опыта');
            $table->text('specialization')->after('experience');
            $table->text('certificates')->nullable()->after('specialization');
            $table->text('quote')->nullable()->after('certificates');
            $table->string('image')->nullable()->after('quote');
            $table->boolean('is_active')->default(true)->after('image');
            $table->integer('sort_order')->default(0)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'position',
                'bio',
                'experience',
                'specialization',
                'certificates',
                'quote',
                'image',
                'is_active',
                'sort_order',
            ]);
        });
    }
};