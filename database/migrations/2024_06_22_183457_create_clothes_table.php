<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClothesTable extends Migration
{
    public function up()
    {
        Schema::create('clothes', function (Blueprint $table) {
            $table->id('ClothID'); // Primary key
            $table->string('Picture');
            $table->text('Description')->nullable();
            $table->string('LinkToBuy')->nullable();
            $table->string('Title');
            $table->foreignId('WardrobeID')->constrained('wardrobes', 'WardrobeID')->onDelete('cascade'); // Specify primary key
            $table->foreignId('TypeID')->constrained('types', 'TypeID')->onDelete('cascade'); // Specify primary key
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clothes');
    }
}

