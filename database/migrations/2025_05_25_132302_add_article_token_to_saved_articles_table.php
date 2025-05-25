<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saved_articles', function (Blueprint $table) {
            $table->string('article_token', 100)->nullable()->after('section');
            $table->unique(['article_token', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::table('saved_articles', function (Blueprint $table) {
            $table->dropUnique(['article_token', 'user_id']);
            $table->dropColumn('article_token');
        });
    }
};
