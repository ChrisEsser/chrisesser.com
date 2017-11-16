<?php

class User extends BaseModel
{
    var $hasMany = [
        'Api' => 'Api',
    ];

}