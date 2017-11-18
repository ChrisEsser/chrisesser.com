<?php

class User extends BaseModel
{

    protected static $_tableName = 'users';
    protected static $_primaryKey = 'id';

    protected static $_tableFields = [
        'username',
        'password',
        'admin',
    ];

    protected static function defineRelations()
    {
        self::addRelationOneToOne('id', 'Api', 'user_id');
    }

    public $id;
    public $username;
    public $password;
    public $admin;

}