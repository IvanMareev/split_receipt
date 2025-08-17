<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('telegram_id')->unique()->nullable()->after('id');
            $table->string('username')->nullable()->after('telegram_id');
            $table->string('last_name')->nullable()->after('username');
            $table->string('photo_url')->nullable()->after('last_name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telegram_id', 'username', 'last_name', 'photo_url']);
        });
    }
};
