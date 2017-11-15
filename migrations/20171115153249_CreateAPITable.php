<?php

use Phpmig\Migration\Migration;

class CreateAPITable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = 'CREATE TABLE apis (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, user_id INT(6) NOT NULL, api_key VARCHAR(255), secret VARCHAR(255), phrase VARCHAR(255))';
        $container = $this->getContainer();
        $container['db']->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = 'DROP TABLE apis';
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
