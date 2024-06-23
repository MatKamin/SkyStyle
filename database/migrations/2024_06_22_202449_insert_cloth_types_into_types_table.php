<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertClothTypesIntoTypesTable extends Migration
{
    public function up()
    {
        $types = [
            ['Title' => 'bag', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'belt', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'bowtie', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'bracelet', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'dress', 'Temperature_min' => 15, 'Temperature_max' => 35, 'isRainOkay' => false, 'LayerUnderID' => null],
            ['Title' => 'earrings', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'glasses', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'gloves', 'Temperature_min' => -10, 'Temperature_max' => 10, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'hair clip', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'hat', 'Temperature_min' => -10, 'Temperature_max' => 35, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'headband', 'Temperature_min' => -10, 'Temperature_max' => 35, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'hosiery', 'Temperature_min' => -10, 'Temperature_max' => 20, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'jumpsuit', 'Temperature_min' => 10, 'Temperature_max' => 30, 'isRainOkay' => false, 'LayerUnderID' => null],
            ['Title' => 'mittens', 'Temperature_min' => -20, 'Temperature_max' => 5, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'necklace', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'necktie', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'outerwear', 'Temperature_min' => -20, 'Temperature_max' => 15, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'pants', 'Temperature_min' => -10, 'Temperature_max' => 35, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'pin/brooch', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'pocket square', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'ring', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'romper', 'Temperature_min' => 15, 'Temperature_max' => 30, 'isRainOkay' => false, 'LayerUnderID' => null],
            ['Title' => 'scarf', 'Temperature_min' => -20, 'Temperature_max' => 10, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'shoes', 'Temperature_min' => -10, 'Temperature_max' => 35, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'shorts', 'Temperature_min' => 20, 'Temperature_max' => 35, 'isRainOkay' => false, 'LayerUnderID' => null],
            ['Title' => 'skirt', 'Temperature_min' => 15, 'Temperature_max' => 30, 'isRainOkay' => false, 'LayerUnderID' => null],
            ['Title' => 'socks', 'Temperature_min' => -10, 'Temperature_max' => 35, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'sunglasses', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'suit', 'Temperature_min' => -10, 'Temperature_max' => 25, 'isRainOkay' => false, 'LayerUnderID' => null],
            ['Title' => 'suspenders', 'Temperature_min' => -10, 'Temperature_max' => 35, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'swimwear', 'Temperature_min' => 25, 'Temperature_max' => 40, 'isRainOkay' => false, 'LayerUnderID' => null],
            ['Title' => 'tie clip', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'top', 'Temperature_min' => 10, 'Temperature_max' => 35, 'isRainOkay' => false, 'LayerUnderID' => null],
            ['Title' => 'vest', 'Temperature_min' => 10, 'Temperature_max' => 25, 'isRainOkay' => false, 'LayerUnderID' => null],
            ['Title' => 'watch', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'rainjacket', 'Temperature_min' => -10, 'Temperature_max' => 30, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'rain boots', 'Temperature_min' => -10, 'Temperature_max' => 30, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'leather jacket', 'Temperature_min' => 0, 'Temperature_max' => 20, 'isRainOkay' => false, 'LayerUnderID' => null],
            ['Title' => 'down jacket', 'Temperature_min' => -20, 'Temperature_max' => 10, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'parka', 'Temperature_min' => -20, 'Temperature_max' => 15, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'fleece jacket', 'Temperature_min' => -10, 'Temperature_max' => 15, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'windbreaker', 'Temperature_min' => 5, 'Temperature_max' => 25, 'isRainOkay' => true, 'LayerUnderID' => null],
            ['Title' => 'umbrella', 'Temperature_min' => -10, 'Temperature_max' => 40, 'isRainOkay' => true, 'LayerUnderID' => null]
        ];

        foreach ($types as $type) {
            DB::table('types')->insert($type);
        }
    }

    public function down()
    {
        DB::table('types')->whereIn('Title', [
            'bag', 'belt', 'bowtie', 'bracelet', 'dress', 'earrings', 'glasses', 'gloves', 'hair clip', 'hat', 'headband',
            'hosiery', 'jumpsuit', 'mittens', 'necklace', 'necktie', 'outerwear', 'pants', 'pin/brooch', 'pocket square',
            'ring', 'romper', 'scarf', 'shoes', 'shorts', 'skirt', 'socks', 'sunglasses', 'suspenders', 'swimwear', 'tie clip',
            'top', 'vest', 'watch', 'suit', 'rainjacket', 'rain boots', 'leather jacket', 'down jacket', 'parka', 'fleece jacket', 'windbreaker', 'umbrella'
        ])->delete();
    }
}
