<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->unique()->after('name');
            }

            if (! Schema::hasColumn('users', 'email')) {
                $table->string('email')->nullable()->unique()->after('phone');
            } else {
                // اگر email از قبل هست و nullable نیست، بهتره nullable کنیم
                // توجه: این require doctrine/dbal می‌خواد. اگر خطا دادی، این بخش رو حذف می‌کنیم.
                // $table->string('email')->nullable()->change();
            }

            if (! Schema::hasColumn('users', 'neighborhood_id')) {
                $table->unsignedBigInteger('neighborhood_id')->nullable()->after('email');
            }

            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status', 20)->default('approved')->after('neighborhood_id');
            }

            if (! Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('status');
            }

            if (! Schema::hasColumn('users', 'profile_completed')) {
                $table->boolean('profile_completed')->default(false)->after('is_active');
            }
        });

        // FK را اینجا اضافه می‌کنیم ولی فقط اگر جدول neighborhoods وجود داشته باشد
        // (اگر در پروژه تو ترتیب migrations درست است، این کار امن است)
        if (Schema::hasTable('neighborhoods')) {
            Schema::table('users', function (Blueprint $table) {
                // جلوگیری از تکرار constraint در migrate:fresh
                // نام constraint را دستی می‌گذاریم تا قابل drop باشد
                $table->foreign('neighborhood_id', 'users_neighborhood_id_fk')
                    ->references('id')->on('neighborhoods')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        // اول FK را حذف می‌کنیم
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                try {
                    $table->dropForeign('users_neighborhood_id_fk');
                } catch (\Throwable $e) {
                    // اگر FK وجود نداشت، مشکلی نیست
                }
            });
        }

        Schema::table('users', function (Blueprint $table) {
            foreach (['profile_completed', 'is_active', 'status', 'neighborhood_id', 'phone'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        // email را در down دست نمی‌زنیم چون معمولاً از قبل وجود داشته
    }
};
