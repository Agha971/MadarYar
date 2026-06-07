<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('neighborhood_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->dateTime('event_date');
            $table->string('location')->nullable();
            $table->integer('capacity')->nullable();
            $table->enum('type', ['community','official'])->default('community');
            $table->timestamps();

            $table->index('neighborhood_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
