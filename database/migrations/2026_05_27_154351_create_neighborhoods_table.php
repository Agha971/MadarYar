<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('neighborhoods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->unsignedBigInteger('parent_id')->nullable(); 
            $table->timestamps();

            // این خط رابطه‌ی درختی خودِ محله‌ها را می‌سازد
            $table->foreign('parent_id')->references('id')->on('neighborhoods')->onDelete('cascade');
        });

        // حالا که جدول محله‌ها ساخته شد، به جدول یوزر می‌گیم که به اینجا وصل بشه
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['neighborhood_id']);
        });
        Schema::dropIfExists('neighborhoods');
    }
};
