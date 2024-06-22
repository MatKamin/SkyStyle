<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodyPartsTable extends Migration
{
    public function up()
    {
        Schema::create('body_parts', function (Blueprint $table) {
            $table->id('LayerUnderID'); // Primary key
            $table->string('Title');
            $table->text('Description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('body_parts');
    }
}

