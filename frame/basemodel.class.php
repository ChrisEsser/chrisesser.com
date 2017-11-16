<?php

class BaseModel extends PicORM\Model
{
    protected $_model;

    protected static $_tableName;
    protected static $_primaryKey;

    function __construct()
    {
        global $inflect;

        \PicORM\PicORM::configure(array(
            'datasource' => new PDO('mysql:dbname=' . getenv('DB_NAME') . ';host=' . getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'))
        ));

//        $this->connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME'));


//        static::$_tableName = strtolower($inflect->pluralize($this->_model));

        $this->_limit = PAGINATE_LIMIT;
        $this->_model = get_class($this);
        $this->_table = strtolower($inflect->pluralize($this->_model));

//        if (!isset($this->abstract)) $this->_describe();
    }

}