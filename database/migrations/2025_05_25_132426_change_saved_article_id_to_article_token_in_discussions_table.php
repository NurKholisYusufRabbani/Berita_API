<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('discussions', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['saved_article_id']);
            
            // Baru hapus kolom
            $table->dropColumn('saved_article_id');

            // Tambahkan kolom article_token
            $table->string('article_token', 100)->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('discussions', function (Blueprint $table) {
            // Hapus kolom token
            $table->dropColumn('article_token');

            // Tambahkan kembali kolom dan foreign key-nya
            $table->unsignedBigInteger('saved_article_id')->after('id');
            $table->foreign('saved_article_id')->references('id')->on('saved_articles')->onDelete('cascade');
        });
    }
};
