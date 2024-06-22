<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWardrobesTable extends Migration
{
    public function up()
    {
        Schema::create('wardrobes', function (Blueprint $table) {
            $table->id('WardrobeID');
            $table->string('Title');
            $table->text('Description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wardrobes');
    }
}
