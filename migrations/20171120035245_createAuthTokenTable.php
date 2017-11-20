<?php

use Phpmig\Migration\Migration;

class CreateAuthTokenTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = 'CREATE TABLE auth_tokens (
          id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          selector VARCHAR(64),
          validator VARCHAR(64),
          user_id INT(11) UNSIGNED NOT NULL,
          expires DATETIME
        )';
        $container = $this->getContainer();
        $container['db']->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = 'DROP TABLE auth_tokens';
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
