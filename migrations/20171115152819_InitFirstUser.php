<?php

use Phpmig\Migration\Migration;

class InitFirstUser extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "INSERT INTO users (username, password) VALUES ('" . getenv('INIT_USERNAME') . "', '" . password_hash(getenv('INIT_USER_PASS'), PASSWORD_DEFAULT) . "')";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "DELETE FROM users WHERE username = '" . getenv('INIT_USERNAME') . "'";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
