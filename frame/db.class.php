<?php

class DB
{
    public $_dbHandle;
    protected $_result;
    protected $_query;
    protected $_table;

    protected $_describe = [];

    protected $_orderBy;
    protected $_order;
    protected $_extraConditions;
    protected $_hO;
    protected $_hM;
    protected $_hMO;
    protected $_hMABTM;
    protected $_page;
    protected $_limit;


    /** Connects to database **/
    function connect($address, $account, $pwd, $name)
    {
        $this->_dbHandle = new mysqli($address, $account, $pwd, $name);

        if (!$this->_dbHandle->connect_errno) {
            return 0;
        } else {
            return 1;
        }
    }


    /** Disconnects from database **/
    function disconnect()
    {
        if ($this->_dbHandle->close()) {
            return 1;
        } else {
            return 0;
        }
    }


    /** Select Query **/
    function where($field, $value)
    {
        $this->_extraConditions .= '`' . strtolower($this->_model) . '`.`' . $field . '` = \'' . mysqli_real_escape_string($this->_dbHandle, $value) . '\' AND ';
    }

    /**
     * @param $field
     * @param $value
     */
    function like($field, $value)
    {
        $this->_extraConditions .= '`' . strtolower($this->_model) . '`.`' . $field . '` LIKE \'%' . mysqli_real_escape_string($this->_dbHandle, $value) . '%\' AND ';
    }

    /**
     *
     */
    function showHasOne()
    {
        $this->_hO = 1;
    }

    /**
     *
     */
    function showHasMany()
    {
        $this->_hM = 1;
    }

    function hasManyOrder($col, $order = 'ASC')
    {
        $this->_hMO = [$col, $order];
    }

    /**
     *
     */
    function showHMABTM()
    {
        $this->_hMABTM = 1;
    }

    /**
     * @param $limit
     */
    function setLimit($limit)
    {
        $this->_limit = $limit;
    }

    /**
     * @param $page
     */
    function setPage($page)
    {
        $this->_page = $page;
    }

    /**
     * @param $orderBy
     * @param string $order
     */
    function orderBy($orderBy, $order = 'ASC')
    {
        $this->_orderBy = $orderBy;
        $this->_order = $order;
    }

    function count()
    {
        global $inflect;

        $this->_model = strtolower($this->_model);

        $from = '`' . $this->_table . '` as `' . $this->_model . '` ';
        $conditions = '\'1\'=\'1\' AND ';


    }

    /**
     * this is the main select method.
     * If there are no relationships, then the function simply does a select * from tableName (tableName is same as controllerName).
     * We can influence this statement, by using the following commands:
     *
     *      where(‘fieldName’,’value’) => Appends WHERE ‘fieldName’ = ‘value’
     *      like(‘fieldName’,’value’) => Appends WHERE ‘fieldName’ LIKE ‘%value%’
     *      setPage(‘pageNumber’) => Enables pagination and display only results for the set page number
     *      setLimit(‘fieldName’,’value’) => Allows you to modify the number of results per page if pageNumber is set. Its default value is the one set in config.php.
     *      orderBy(‘fieldName’,’Order’) => Appends ORDER BY ‘fieldName’ ASC/DESC
     *      id = X => Will display only a single result of the row matching the id
     *
     * if showHasOne() has been called, then for each hasOne relationship, a LEFT JOIN is done
     *
     * if showHasMany() function has been called, then for each result returned by the above query and for each hasMany
     *      relationship, it will find all those records in the second table which match the current result’s id.
     *      Then it will push all those results in the same array. For example, if teachers hasMany students, then
     *      $this->Teacher->showHasMany() will search for teacher_id in the students table.
     *
     * if showHMABTM() function has been called, then for each result returned by the first query and for each
     *      hasManyAndBelongsToMany relationship, it will find all those records which match the current result’s id.
     *      For example, if teachers hasManyAndBelongsToMany students, then $this->Teacher->showHMABTM()
     *      will search for teacher_id in students_teachers table.
     *
     * @return array|mixed
     */
    function search()
    {
        global $inflect;

        $this->_model = strtolower($this->_model);

        $from = '`' . $this->_table . '` as `' . $this->_model . '` ';
        $conditions = '\'1\'=\'1\' AND ';

        $conditionsChild = '';
        $fromChild = '';

        if ($this->_hO == 1 && isset($this->hasOne)) {

            foreach ($this->hasOne as $alias => $model) {
                $table = strtolower($inflect->pluralize($model));
                $singularAlias = strtolower($alias);
                $from .= 'LEFT JOIN `' . $table . '` as `' . $alias . '` ';
                $from .= 'ON `' . $this->_model . '`.`' . $singularAlias . '_id` = `' . $alias . '`.`id`  ';
            }
        }

        if ($this->id) {
            $conditions .= '`' . $this->_model . '`.`id` = \'' . mysqli_real_escape_string($this->_dbHandle, $this->id) . '\' AND ';
        }
        if ($this->_extraConditions) {
            $conditions .= $this->_extraConditions;
        }

        $conditions = substr($conditions, 0, -4);

        if (isset($this->_orderBy)) {
            $conditions .= ' ORDER BY `' . $this->_model . '`.`' . $this->_orderBy . '` ' . $this->_order;
        }

        if (isset($this->_page)) {
            $offset = ($this->_page - 1) * $this->_limit;
            $conditions .= ' LIMIT ' . $this->_limit . ' OFFSET ' . $offset;
        }

        $this->_query = 'SELECT * FROM ' . $from . ' WHERE ' . $conditions;

        $this->_result = mysqli_query($this->_dbHandle, $this->_query);
        $result = [];
        $table = [];
        $field = [];
        $tempResults = [];

        $numOfFields = 0;

        if ($this->_result) {

            $numOfFields = ($this->_result) ? mysqli_num_fields($this->_result) : 0;

            for ($i = 0; $i < $numOfFields; ++$i) {
                array_push($table, mysqli_fetch_field_direct($this->_result, $i)->table);
                array_push($field, mysqli_fetch_field_direct($this->_result, $i)->name);
            }
        }


        if ($this->_result) {

            if (mysqli_num_rows($this->_result) > 0) {

                while ($row = mysqli_fetch_row($this->_result)) {

                    for ($i = 0; $i < $numOfFields; ++$i) {
                        $tempResults[$table[$i]][$field[$i]] = $row[$i];
                    }

                    if ($this->_hM == 1 && isset($this->hasMany)) {

                        foreach ($this->hasMany as $aliasChild => $modelChild) {

                            $tableChild = strtolower($inflect->pluralize($modelChild));
                            $pluralAliasChild = strtolower($inflect->pluralize($aliasChild));

                            $fromChild = '`' . $tableChild . '` as `' . $aliasChild . '`';
                            $conditionsChild = '`' . $aliasChild . '`.`' . $this->_model . '_id` = \'' . $tempResults[$this->_model]['id'] . '\'';

                            $queryChild = 'SELECT * FROM ' . $fromChild . ' WHERE ' . $conditionsChild;
                            $queryChild .= (!empty($this->_hMO)) ? ' ORDER BY `' . $this->_hMO[0] . '` ' . $this->_hMO[1] . '' : "";

                            $resultChild = mysqli_query($this->_dbHandle, $queryChild);

                            $tableChild = [];
                            $fieldChild = [];
                            $tempResultsChild = [];
                            $resultsChild = [];

                            if (!empty($resultChild)) {

                                if (mysqli_num_rows($resultChild) > 0) {

                                    $numOfFieldsChild = mysqli_num_fields($resultChild);

                                    for ($j = 0; $j < $numOfFieldsChild; ++$j) {
                                        array_push($tableChild, mysqli_fetch_field_direct($resultChild, $j)->table);
                                        array_push($fieldChild, mysqli_fetch_field_direct($resultChild, $j)->name);
                                    }


                                    while ($rowChild = mysqli_fetch_row($resultChild)) {

                                        for ($j = 0; $j < $numOfFieldsChild; ++$j) {
                                            $tempResultsChild[$fieldChild[$j]] = $rowChild[$j];
                                        }

                                        array_push($resultsChild, $tempResultsChild);
                                    }
                                }

                                $tempResults[$pluralAliasChild] = $resultsChild;

                            }

                            if ($resultChild) mysqli_free_result($resultChild);
                        }
                    }


                    if ($this->_hMABTM == 1 && isset($this->hasManyAndBelongsToMany)) {

                        foreach ($this->hasManyAndBelongsToMany as $aliasChild => $tableChild) {

                            $tableChild = strtolower($inflect->pluralize($tableChild));
                            $pluralAliasChild = strtolower($inflect->pluralize($aliasChild));
                            $singularAliasChild = strtolower($aliasChild);

                            $sortTables = [$this->_table, $pluralAliasChild];
                            sort($sortTables);
                            $joinTable = implode('_', $sortTables);

                            $fromChild = '`' . $tableChild . '` as `' . $aliasChild . '`,';
                            $fromChild .= '`' . $joinTable . '`,';

                            $conditionsChild = '`' . $joinTable . '`.`' . $singularAliasChild . '_id` = `' . $aliasChild . '`.`id` AND ';
                            $conditionsChild .= '`' . $joinTable . '`.`' . $this->_model . '_id` = \'' . $tempResults[$this->_model]['id'] . '\'';

                            $fromChild = substr($fromChild, 0, -1);

                            $queryChild = 'SELECT * FROM ' . $fromChild . ' WHERE ' . $conditionsChild;
                            $resultChild = mysqli_query($this->_dbHandle, $queryChild);

                            $tableChild = [];
                            $fieldChild = [];
                            $tempResultsChild = [];
                            $resultsChild = [];

                            if (!empty($resultChild) && mysqli_num_rows($resultChild) > 0) {

                                $numOfFieldsChild = mysqli_num_fields($resultChild);

                                for ($j = 0; $j < $numOfFieldsChild; ++$j) {
                                    array_push($tableChild, mysqli_fetch_field_direct($resultChild, $j)->table);
                                    array_push($fieldChild, mysqli_fetch_field_direct($resultChild, $j)->name);
                                }

                                while ($rowChild = mysqli_fetch_row($resultChild)) {

                                    for ($j = 0; $j < $numOfFieldsChild; ++$j) {
                                        $tempResultsChild[$fieldChild[$j]] = $rowChild[$j];
                                    }

                                    array_push($resultsChild, $tempResultsChild);
                                }
                            }

                            $tempResults[$singularAliasChild] = $resultsChild;
                            if (!empty($resultChild)) {
                                mysqli_free_result($resultChild);
                            }
                        }
                    }

                    array_push($result, $tempResults);
                }

                if (mysqli_num_rows($this->_result) == 1 && $this->id != null) {

                    mysqli_free_result($this->_result);
                    $this->clear();
                    return ($result[0]);

                } else {

                    mysqli_free_result($this->_result);
                    $this->clear();
                    return ($result);
                }
            } else {

                mysqli_free_result($this->_result);
                $this->clear();
                return $result;
            }
        }

        return [];
    }

    /** Custom SQL Query *
     *
     * @param $query
     * @return array
     */
    function custom($query)
    {
        global $inflect;

        $this->_result = mysqli_query($this->_dbHandle, $query);

        $result = [];
        $table = [];
        $field = [];
        $tempResults = [];

        if ($this->_result) {

            if (substr_count(strtoupper($query), "SELECT") > 0) {

                if (mysqli_num_rows($this->_result) > 0) {

                    $numOfFields = mysqli_num_fields($this->_result);

                    for ($i = 0; $i < $numOfFields; ++$i) {
                        array_push($table, mysqli_fetch_field_direct($this->_result, $i)->table);
                        array_push($field, mysqli_fetch_field_direct($this->_result, $i)->name);
                    }

                    while ($row = mysqli_fetch_row($this->_result)) {

                        for ($i = 0; $i < $numOfFields; ++$i) {
                            $table[$i] = strtolower($inflect->singularize($table[$i]));
                            $tempResults[$table[$i]][$field[$i]] = $row[$i];
                        }

                        array_push($result, $tempResults);
                    }
                }

                mysqli_free_result($this->_result);
            }
        }

        $this->clear();
        return ($result);
    }


    /** Describes a Table **/
    protected function _describe()
    {

        global $cache;

        $this->_describe = $cache->get('describe' . $this->_table);

        if (!$this->_describe) {
            $this->_describe = [];
            $query = 'DESCRIBE ' . $this->_table;
            $this->_result = mysqli_query($this->_dbHandle, $query);

            if ($this->_result) {
                while ($row = mysqli_fetch_row($this->_result)) {
                    array_push($this->_describe, $row[0]);
                }

                mysqli_free_result($this->_result);
                $cache->set('describe' . $this->_table, $this->_describe);
            }


        }

//        foreach ($this->_describe as $field) {
//            $this->$field = null;
//        }
    }


    /** Delete an Object **/
    function delete()
    {
        if ($this->id) {

            $query = 'DELETE FROM `' . $this->_table . '` WHERE `id` = \'' . mysqli_real_escape_string($this->_dbHandle, $this->id) . '\'';


//            $query = 'UPDATE ' . $this->_table . ' SET `deleted` = 1 WHERE `id`= \'' . mysqli_real_escape_string($this->_dbHandle, $this->id) . '\'';
            $this->_result = mysqli_query($this->_dbHandle, $query);
            $this->clear();

            if ($this->_result == 0) {
                /** Errors **/
                return false;
            }

        } else {
            /** Errors **/
            return false;
        }

        return true;

    }


    /** Saves an Object i.e. Updates/Inserts Query **/
    function save()
    {
        if (isset($this->id)) {

            $updates = '';

            foreach ($this->_describe as $field) {

                if ($this->$field) {
                    $updates .= '`' . $field . '` = \'' . mysqli_real_escape_string($this->_dbHandle, $this->$field) . '\',';
                }
            }

            $updates = substr($updates, 0, -1);

            $query = 'UPDATE ' . $this->_table . ' SET ' . $updates . ' WHERE `id`=\'' . mysqli_real_escape_string($this->_dbHandle, $this->id) . '\'';


        } else {

            $fields = '';
            $values = '';

            foreach ($this->_describe as $field) {

                if ($this->$field) {
                    $fields .= '`' . $field . '`,';
                    $values .= '\'' . mysqli_real_escape_string($this->_dbHandle, $this->$field) . '\',';
                }
            }

            $values = substr($values, 0, -1);
            $fields = substr($fields, 0, -1);

            $query = 'INSERT INTO ' . $this->_table . ' (' . $fields . ') VALUES (' . $values . ')';
        }

        $db = $this->_dbHandle;

        $this->_result = mysqli_query($this->_dbHandle, $query);

        if ($this->_result) {
            $id = $this->id;
            $this->clear();
            return (!empty($id)) ? true : mysqli_insert_id($db);
        }

        /** Errors **/

        return false;
    }


    function getLastInsertId()
    {
        return mysqli_insert_id($this->_dbHandle);
    }

    /** Clear All Variables **/
    function clear()
    {
//        foreach ($this->_describe as $field) {
//            $this->$field = null;
//        }

        $this->_orderby = null;
        $this->_extraConditions = null;
        $this->_hO = null;
        $this->_hM = null;
        $this->_hMABTM = null;
        $this->_page = null;
        $this->_order = null;
    }


    /** Pagination Count **/
    function totalPages()
    {
        if ($this->_query && $this->_limit) {

            $pattern = '/SELECT (.*?) FROM (.*)LIMIT(.*)/i';
            $replacement = 'SELECT COUNT(*) FROM $2';
            $countQuery = preg_replace($pattern, $replacement, $this->_query);
            $this->_result = mysqli_query($this->_dbHandle, $countQuery);
            $count = mysqli_fetch_row($this->_result);
            $totalPages = ceil($count[0] / $this->_limit);

            return $totalPages;

        } else {
            /* Error Code Here */
            return false;
        }
    }


    /** Get error string **/
    function getError()
    {
        return mysqli_error($this->_dbHandle);
    }
}