<?php

class DataObject
{
    /** @var  PDO */
    protected $_db;

    protected $_table;
    protected $_query;
    protected $_extraConditions = [];
    protected $_result;

    protected $_hO;
    protected $_hM;
    protected $_hMABTM;
    protected $_hMO;

    protected $_describe = [];
    protected $_limit;
    protected $_page;

    function connect($host, $user, $pass, $db)
    {
        $dsn = 'mysql:dbname=' . $db . ';host=' . $host;
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $this->_db = new PDO($dsn, $user, $pass);
        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    function where($field, $value)
    {
        $this->_extraConditions['where'][$field] = $value;
    }

    function like($field, $value)
    {
        $this->_extraConditions['like'][$field] = $value;
    }

    function showHasOne()
    {
        $this->_hO = 1;
    }

    function showHasMany()
    {
        $this->_hM = 1;
    }

    function showHMABTM()
    {
        $this->_hMABTM = 1;
    }

    function hasManyOrder($col, $order = 'ASC')
    {
        $this->_hMO = [$col, $order];
    }

    function search()
    {

        global $inflect;
        global $cache;

        $this->_model = strtolower($this->_model);
        $conditions = "'1' = '1' ";
        $preparedVars = [];

        $from = '`' . $this->_table . '` as `' . $this->_table . '` ';

        if ($this->_hO == 1 && isset($this->hasOne)) {

            foreach ($this->hasOne as $alias => $model) {
                $table = strtolower($inflect->pluralize($model));
                $from .= 'LEFT JOIN `' . $table . '` as `' . $table . '` ';
                $from .= 'ON `' . $table . '`.`' . $this->_model . '_id` = `' . $this->_table . '`.`id`  ';
            }

        }


        if (!empty($this->_extraConditions['where'])) {
            foreach($this->_extraConditions['where'] as $field => $value) {
                $conditions .= ' AND `' . $this->_table . '`.`' . $field . '` = :' . $field . ' ';
                $preparedVars[':' . $field] = $value;
            }
        }

        if (!empty($this->_extraConditions['like'])) {
            foreach($this->_extraConditions['like'] as $field => $value) {
                $conditions .= ' AND `' . $this->_table . '`.`' . $field . '` LIKE :' . $field . ' ';
                $preparedVars[':' . $field] = '%' . $value . '%';
            }
        }


        $this->_query = 'SELECT * ';
        $this->_query .= ' FROM ' . $from . ' WHERE ' . $conditions;
        $statement = $this->_db->prepare($this->_query);

        foreach($preparedVars as $field => $value) {
            $statement->bindValue($field, $value);
        }

        $statement->execute($preparedVars);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $return = [];
        if (count($results)) {

            $i = 0;

            foreach ($results as $row) {

                foreach ($this->_describe as $column) {
                    $return[$i][$this->_table][$column] = $row[$column];
                }

                foreach ($this->hasOne as $alias => $model) {
                    $table = strtolower($inflect->pluralize($model));
                    $thisDescribe = $cache->get('describe' . $table);
                    foreach ($thisDescribe as $column) {
                        $return[$i][$table][$column] = $row[$column];
                    }
                }

                $i++;
            }

        }

        return $return;

    }

    function disconnect()
    {
        $this->_db = null;
    }

    protected function _describe()
    {

        global $cache;

        $this->_describe = $cache->get('describe' . $this->_table);

        if (!$this->_describe) {

            $this->_describe = [];
            $q = $this->_db->prepare('DESCRIBE ' . $this->_table);
            $q->execute();
            $this->_describe[] = $q->fetchAll(PDO::FETCH_COLUMN);
            $cache->set('describe' . $this->_table, $this->_describe);

        }

    }


}
