<?php

use Phpmig\Migration\Migration;

class AddAminColumnToUserTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = 'ALTER TABLE users ADD COLUMN admin BIT DEFAULT 0';
        $container = $this->getContainer();
        $container['db']->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = 'ALTER TABLE users DROP admin';
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
