<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksAfterInsertTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	DB::unprepared('
		CREATE
        		TRIGGER `blocks_after_insert` AFTER INSERT
		        ON blocks
        		        FOR EACH ROW BEGIN
                		        SET @median = (select AVG(size) median_size from (select size from (SELECT size FROM blocks WHERE height < NEW.height ORDER BY height desc LIMIT 100) t ORDER BY size limit 49,2) tt);
                        		INSERT INTO block_median (block_height, median) VALUES(NEW.height, @median);
		        END
			');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `blocks_after_insert`');
    }
}
