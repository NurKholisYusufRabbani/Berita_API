<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::create('saved_articles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->string('url');
        $table->text('summary')->nullable();
        $table->string('section')->nullable();
        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::dropIfExists('saved_articles');
    }
};
