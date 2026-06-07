<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('neighborhood_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('type', ['borrow','sell','free']);
            $table->enum('status', ['active','reserved','done'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index('neighborhood_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
