<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateTypesLogicalRelationships extends Migration
{
    public function up()
    {
        DB::statement("
            UPDATE types
            SET \"ParentTypeID\" = CASE
                WHEN \"Title\" = 'necktie' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'suit')
                WHEN \"Title\" = 'tie clip' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'necktie')
                WHEN \"Title\" = 'belt' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'pants')
                WHEN \"Title\" = 'scarf' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'top')
                WHEN \"Title\" = 'vest' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'top')
                WHEN \"Title\" = 'gloves' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'outerwear')
                WHEN \"Title\" = 'hat' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'head')
                WHEN \"Title\" = 'socks' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'shoes')
                WHEN \"Title\" = 'bracelet' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'hands')
                WHEN \"Title\" = 'earrings' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'head')
                WHEN \"Title\" = 'glasses' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'head')
                WHEN \"Title\" = 'watch' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'hands')
                WHEN \"Title\" = 'ring' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'hands')
                WHEN \"Title\" = 'bowtie' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'suit')
                WHEN \"Title\" = 'rainjacket' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'outerwear')
                WHEN \"Title\" = 'leather jacket' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'outerwear')
                WHEN \"Title\" = 'down jacket' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'outerwear')
                WHEN \"Title\" = 'parka' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'outerwear')
                WHEN \"Title\" = 'fleece jacket' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'outerwear')
                WHEN \"Title\" = 'windbreaker' THEN (SELECT \"TypeID\" FROM types WHERE \"Title\" = 'outerwear')
                ELSE \"LayerUnderID\"
            END,
            \"LayerUnderID\" = CASE
                WHEN \"Title\" = 'top' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Upper Body')
                WHEN \"Title\" = 'pants' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Lower Body')
                WHEN \"Title\" = 'shoes' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Feet')
                WHEN \"Title\" = 'hat' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Head')
                WHEN \"Title\" = 'gloves' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Hands')
                WHEN \"Title\" = 'bracelet' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Hands')
                WHEN \"Title\" = 'earrings' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Head')
                WHEN \"Title\" = 'glasses' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Head')
                WHEN \"Title\" = 'watch' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Hands')
                WHEN \"Title\" = 'ring' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Hands')
                WHEN \"Title\" = 'belt' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Lower Body')
                WHEN \"Title\" = 'scarf' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Upper Body')
                WHEN \"Title\" = 'vest' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Upper Body')
                WHEN \"Title\" = 'bag' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Accessories')
                WHEN \"Title\" = 'necklace' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Accessories')
                WHEN \"Title\" = 'pin/brooch' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Accessories')
                WHEN \"Title\" = 'sunglasses' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Head')
                WHEN \"Title\" = 'rainjacket' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Outerwear')
                WHEN \"Title\" = 'rain boots' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Feet')
                WHEN \"Title\" = 'leather jacket' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Outerwear')
                WHEN \"Title\" = 'down jacket' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Outerwear')
                WHEN \"Title\" = 'parka' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Outerwear')
                WHEN \"Title\" = 'fleece jacket' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Outerwear')
                WHEN \"Title\" = 'windbreaker' THEN (SELECT \"LayerUnderID\" FROM body_parts WHERE \"Title\" = 'Outerwear')
                ELSE \"ParentTypeID\"
            END;
        ");
    }

    public function down()
    {
        // Rollback the updates (Optional)
        DB::statement("
            UPDATE types
            SET \"LayerUnderID\" = NULL, \"ParentTypeID\" = NULL
            WHERE \"LayerUnderID\" IS NOT NULL OR \"ParentTypeID\" IS NOT NULL;
        ");
    }
}
