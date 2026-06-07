<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hamyar_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('cooperation_type', 50); // mosque | sara | neighborhood | support | sponsor | ...
            $table->foreignId('neighborhood_id')->nullable();

            $table->string('organization_name')->nullable();
            $table->string('position_title')->nullable();

            $table->text('experience_text')->nullable();
            $table->text('skills_text')->nullable();
            $table->text('availability_text')->nullable();
            $table->text('description')->nullable();

            $table->timestamp('reviewed_at')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable(); // بعداً FK به users می‌زنیم
            $table->text('approval_note')->nullable();

            $table->timestamps();

            $table->index(['cooperation_type']);
            $table->index(['neighborhood_id']);
        });

        // FK اختیاری به neighborhoods (اگر جدول وجود دارد)
        if (Schema::hasTable('neighborhoods')) {
            Schema::table('hamyar_profiles', function (Blueprint $table) {
                $table->foreign('neighborhood_id', 'hamyar_profiles_neighborhood_id_fk')
                    ->references('id')->on('neighborhoods')
                    ->nullOnDelete();
            });
        }

        // FK reviewed_by به users (اختیاری)
        Schema::table('hamyar_profiles', function (Blueprint $table) {
            $table->foreign('reviewed_by', 'hamyar_profiles_reviewed_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('hamyar_profiles', function (Blueprint $table) {
            try { $table->dropForeign('hamyar_profiles_reviewed_by_fk'); } catch (\Throwable $e) {}
            try { $table->dropForeign('hamyar_profiles_neighborhood_id_fk'); } catch (\Throwable $e) {}
        });

        Schema::dropIfExists('hamyar_profiles');
    }
};
