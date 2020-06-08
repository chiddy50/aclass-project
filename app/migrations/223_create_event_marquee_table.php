<?php

class Migration_create_event_marquee_table extends Migration
{

    public function up()
    {
        $table = Base::table('event_marquee');

        if (! $this->has_table($table)) {
            $sql = 'CREATE TABLE IF NOT EXISTS `' . $table . '` (
				`id` int(6) NOT NULL AUTO_INCREMENT,
				`title` varchar(255) NOT NULL,
				`description` text NOT NULL,
                `banquet_capacity int default 0`,
                `theatre_capacity int default 0`,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB';

            DB::query($sql);
        }
    }

    public function down()
    {
    }
}
