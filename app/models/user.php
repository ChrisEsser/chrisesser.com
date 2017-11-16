<?php

class User extends BaseModel
{

    protected static $_tableName = 'users';
    protected static $_primaryKey = 'id';

    protected static $_tableFields = [
        'username',
        'password',
    ];

    protected static function defineRelations()
    {
        self::addRelationOneToMany('id', 'Api', 'user_id');
    }

    public $id;
    public $username;
    public $password;

}