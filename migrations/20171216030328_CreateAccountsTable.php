<?php

use Phpmig\Migration\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = 'CREATE TABLE accounts (
          id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          user_id INT(11) UNSIGNED NOT NULL,
          type VARCHAR(255),
          market_name VARCHAR(25),
          balance DECIMAL(17,10)
        )';
        $container = $this->getContainer();
        $container['db']->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = 'DROP TABLE accounts';
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
