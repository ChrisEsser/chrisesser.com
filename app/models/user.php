<?php

class User extends BaseModel
{
    var $hasOne = [
        'Api' => 'Api',
    ];

}