<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertDefaultBodyParts extends Migration
{
    public function up()
    {
        // Insert default body parts
        DB::table('body_parts')->insert([
            ['Title' => 'Upper Body'],
            ['Title' => 'Lower Body'],
            ['Title' => 'Feet'],
            ['Title' => 'Head'],
            ['Title' => 'Hands'],
            ['Title' => 'Accessories']
        ]);
    }

    public function down()
    {
        // Remove the inserted body parts
        DB::table('body_parts')->whereIn('Title', [
            'Upper Body', 'Lower Body', 'Feet', 'Head', 'Hands', 'Accessories'
        ])->delete();
    }
}
