<?php

class Api extends BaseModel
{

    protected static $_tableName = 'apis';
    protected static $_primaryKey = 'id';

    protected static $_tableFields = [
        'user_id',
        'api_key',
        'secret',
        'phrase',
    ];

    protected static function defineRelations()
    {
        self::addRelationOneToOne('user_id', 'User', 'id');
    }

    public $id;
    public $user_id;
    public $api_key;
    public $secret;
    public $phrase;

}