<?php

class BaseModel extends DB
{
    protected $_model;

    function __construct()
    {
        global $inflect;

        $this->connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME'));

        $this->_limit = PAGINATE_LIMIT;
        $this->_model = get_class($this);
        $this->_table = strtolower($inflect->pluralize($this->_model));

        if (!isset($this->abstract)) $this->_describe();
    }

}