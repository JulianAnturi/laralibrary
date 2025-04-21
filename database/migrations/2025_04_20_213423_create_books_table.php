<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('isbn', 20);
            $table->string('url');
            $table->integer('state')->nullable();
            $table->integer('quantity');
            $table->integer('lended')->nullable();
            $table->integer('price');
            $table->text('sypnosis')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
};
