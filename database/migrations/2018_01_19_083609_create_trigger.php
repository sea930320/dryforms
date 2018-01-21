<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER add_equipment AFTER INSERT ON equipments
            FOR EACH ROW
            BEGIN
                UPDATE equipment_models
                SET total = total + 1 WHERE NEW.model_id = equipment_models.id AND NEW.company_id = equipment_models.company_id;
            END;
        ');
        DB::unprepared('
        CREATE TRIGGER delete_equipment AFTER DELETE ON equipments
            FOR EACH ROW
            BEGIN
                UPDATE equipment_models
                SET total = total - 1 WHERE OLD.model_id = equipment_models.id AND OLD.company_id = equipment_models.company_id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS add_equipment');
        DB::unprepared('DROP TRIGGER IF EXISTS delete_equipment');
    }
}
