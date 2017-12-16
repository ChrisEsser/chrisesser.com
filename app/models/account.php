<?php

class Account extends BaseModel
{

    protected static $_tableName = 'accounts';
    protected static $_primaryKey = 'id';

    protected static $_tableFields = [
        'user_id',
        'type',
        'market_name',
        'balance',
    ];

    protected static function defineRelations()
    {
        self::addRelationOneToOne('user_id', 'User', 'id');
    }

    public $id;
    public $user_id;
    public $market_name;
    public $balance;

}