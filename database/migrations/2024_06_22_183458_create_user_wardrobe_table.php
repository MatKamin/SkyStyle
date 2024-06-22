<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWardrobeTable extends Migration
{
    public function up()
    {
        Schema::create('user_wardrobe', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('UserID')->constrained('users')->onDelete('cascade');
            $table->foreignId('WardrobeID')->constrained('wardrobes', 'WardrobeID')->onDelete('cascade'); // Specify primary key
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_wardrobe');
    }
}
