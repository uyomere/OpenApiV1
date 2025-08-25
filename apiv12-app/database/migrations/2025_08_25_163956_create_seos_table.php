<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('seos', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->text('meta_keywords');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seos');
    }
};
