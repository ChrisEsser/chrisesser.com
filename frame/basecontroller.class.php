<?php

class BaseController
{

    protected $_controller;
    protected $_action;
    protected $_template;

    public $render;
    public $site_id;
    public $render_header;

    /**
     * BaseController constructor.
     * @param $controller
     * @param $action
     */
    function __construct($controller, $action = null)
    {
        global $inflect;

        $this->_controller = ucfirst($controller);
        $this->_action = $action;

        $model = ucfirst($inflect->singularize($controller));
        $this->render = 1;
        $this->render_header = 1;
        $this->$model = new $model;

        $this->_template = new Template($controller, $action);

    }

    /**
     * @param $name
     * @param $value
     */
    function set($name, $value)
    {
        $this->_template->set($name, $value);
    }

    function __destruct()
    {
        if ($this->render) {
            $this->_template->render($this->render_header);
        }
    }

}