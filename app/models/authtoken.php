<?php


class AuthToken extends BaseModel
{
    protected static $_tableName = 'auth_tokens';
    protected static $_primaryKey = 'id';

    protected static $_tableFields = [
        'selector',
        'validator',
        'user_id',
        'expires',
    ];

    protected static function defineRelations()
    {
        self::addRelationOneToOne('user_id', 'User', 'id');
    }

    public $id;
    public $selector;
    public $validator;
    public $user_id;
    public $expires;
}