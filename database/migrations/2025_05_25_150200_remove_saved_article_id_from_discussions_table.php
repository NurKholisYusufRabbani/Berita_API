<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('discussions', function (Blueprint $table) {
            // Hapus foreign key constraint-nya dulu
            $table->dropForeign(['saved_article_id']);

            // Baru hapus kolomnya
            $table->dropColumn('saved_article_id');
        });
    }

    public function down(): void
    {
        Schema::table('discussions', function (Blueprint $table) {
            $table->unsignedBigInteger('saved_article_id')->nullable();

            // Kalau kamu ingin kembalikan foreign key-nya, kamu bisa tambahkan ini
            $table->foreign('saved_article_id')->references('id')->on('saved_articles')->onDelete('cascade');
        });
    }
};
