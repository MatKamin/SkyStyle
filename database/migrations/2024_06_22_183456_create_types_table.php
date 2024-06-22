<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id('TypeID'); // Primary key
            $table->string('Title');
            $table->text('Description')->nullable();
            $table->float('Temperature_min')->nullable();
            $table->float('Temperature_max')->nullable();
            $table->boolean('isRainOkay')->default(false);
            $table->foreignId('ParentTypeID')->nullable()->constrained('types', 'TypeID')->onDelete('cascade'); // Specify primary key
            $table->foreignId('LayerUnderID')->nullable()->constrained('body_parts', 'LayerUnderID')->onDelete('cascade'); // Specify primary key
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('types');
    }
}

