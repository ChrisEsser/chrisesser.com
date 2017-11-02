<?php

class Template
{

    protected $variables = [];
    protected $_controller;
    protected $_action;
    protected $html;

    /**
     * Template constructor.
     * @param $controller
     * @param $action
     */
    public function __construct($controller, $action = null)
    {
        $this->_controller = $controller;
        $this->_action = $action;
    }


    /** Set variables *
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    /** Display the template *
     */
    public function render($renderHeader = 1)
    {
        extract($this->variables);

        $viewsRoot = ROOT . DS . 'app' . DS . 'views' . DS;

        if ($renderHeader == 1 && file_exists($viewsRoot . 'index.header.php')) {
            include($viewsRoot . 'index.header.php');
        }

        if (file_exists($viewsRoot . $this->_controller . DS . $this->_action  . '.php')) {

            if (file_exists($viewsRoot . $this->_controller . DS . 'header'  . '.php')) {
                include($viewsRoot . $this->_controller . DS . 'header'  . '.php');
            }

            include($viewsRoot . $this->_controller . DS . $this->_action  . '.php');

            if (file_exists($viewsRoot . $this->_controller . DS . 'footer'  . '.php')) {
                include($viewsRoot . $this->_controller . DS . 'footer'  . '.php');
            }
        }

        if ($renderHeader == 1 && file_exists($viewsRoot . 'index.footer.php')) {
            include($viewsRoot . 'index.footer.php');
        }

        $request = BASE_PATH . '/' . str_replace('_url=', '', $_SERVER['QUERY_STRING']);
        if(substr($request, -1) == '/') {
            $request = substr($request, 0, -1);
        }

        Redirect::addToQueue($request);

    }

}