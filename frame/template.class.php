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

        $_controller = strtolower($this->_controller);
        $_action = strtolower($this->_action);


        // check for a view file matching the action
        if (file_exists($viewsRoot . $_controller . DS . $_action  . '.php')) {

            // site default header
            if ($renderHeader == 1 && file_exists($viewsRoot . 'index.header.php')) {
                include($viewsRoot . 'index.header.php');
            }


            // controller global header
            if (file_exists($viewsRoot . $_controller . DS . 'header'  . '.php')) {
                include($viewsRoot . $_controller . DS . 'header'  . '.php');
            }

            // display this action's view
            include($viewsRoot . $_controller . DS . $_action  . '.php');

            // controller global footer
            if (file_exists($viewsRoot . $_controller . DS . 'footer'  . '.php')) {
                include($viewsRoot . $_controller . DS . 'footer'  . '.php');
            }

        } else {
            http_response_code(404);
            exit();
        }

        // site default footer
        if ($renderHeader == 1 && file_exists($viewsRoot . 'index.footer.php')) {
            include($viewsRoot . 'index.footer.php');
        }


        // add the rendered view request to the rewind queue
        $request = BASE_PATH . '/' . str_replace('_url=', '', $_SERVER['QUERY_STRING']);
        if(substr($request, -1) == '/') {
            $request = substr($request, 0, -1);
        }
        Redirect::addToQueue($request);

    }

}