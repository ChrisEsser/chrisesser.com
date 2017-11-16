<?php


spl_autoload_register( function( $className ) {

    $className = strtolower($className);

    $framePath = ROOT . DS . 'frame' . DS . $className . '.class.php';
    $appClassesPath = ROOT . DS . 'app' . DS . 'classes' . DS . $className . '.class.php';
    $controllersPath = ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php';
    $modelsPath = ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php';

    if (file_exists($framePath)) {
        require $framePath;
    } elseif (file_exists($appClassesPath)) {
        require $appClassesPath;
    } elseif (file_exists($controllersPath )) {
        require $controllersPath;
    } elseif (file_exists($modelsPath )) {
        require $modelsPath;
    } else {
        http_response_code(500);
        echo 'Class not found';
        die;
    }


});


/** GZip Output **/
function gzipOutput()
{
//    $ua = $_SERVER['HTTP_USER_AGENT'];
//
//    if (strpos($ua, 'Mozilla/4.0 (compatible; MSIE ') !== false || strpos($ua, 'Opera') !== false) {
//        return false;
//    }
//
//    echo '<pre>';
//    $browser = get_browser(null, true);
//
////    $version = (float)substr($ua, 30);
//    var_dump($browser);
////    var_dump($version);
//    die;
//    return (
//        $version < 6 || ($version == 6 && strpos($ua, 'SV1') === false)
//    );


    return true;
}


function env($key, $default = null)
{
    $value = getenv($key);

    if ($value === false) {
        return value($default);
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;
        case 'false':
        case '(false)':
            return false;
        case 'empty':
        case '(empty)':
            return '';
        case 'null':
        case '(null)':
            return;
    }

    if (strlen($value) > 1 && Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
        return substr($value, 1, -1);
    }

    return $value;
}

function value($value)
{
    return $value instanceof Closure ? $value() : $value;
}

/** Check if environment is development and display errors **/
function setReporting()
{
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors', 'Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
    }
}

/** Remove magic quotes **/
function removeMagicQuotes()
{
    if (get_magic_quotes_gpc()) {
        $_GET = stripSlashesDeep($_GET);
        $_POST = stripSlashesDeep($_POST);
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}

/** Check for Magic Quotes and remove them *
 * @param $value
 * @return array|string
 */
function stripSlashesDeep($value)
{
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}

/** Check register globals and remove them **/
function unregisterGlobals()
{
    if (ini_get('register_globals')) {

        $array = ['_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES'];

        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

/** check csrf token */
function checkCSRF()
{
    if (!empty($_POST)) {

        if (CSRF::validate($_POST) ) {
            return true;
        } else {
            return false;
        }
    }

    return true;

}

/** Routing *
 * @param $url
 * @return mixed
 */
function routeURL($url)
{
    global $routing;

    foreach ($routing as $pattern => $result) {
        if (preg_match($pattern, $url)) {
            return preg_replace($pattern, $result, $url);
        }
    }

    return ($url);
}


/**
 * @param $controller
 * @param $action
 * @param null $queryString
 * @param int $render
 * @return mixed
 */
function getAction($controller, $action, $queryString = null, $render = 0)
{
    $controllerName = ucfirst($controller) . 'Controller';
    $dispatch = new $controllerName($controller, $action);
    $dispatch->render = $render;

    return call_user_func_array([$dispatch, $action], $queryString);
}


/**
 * @param $e
 */
function addSiteError($e)
{
    $_SESSION['frame']['site_errors'][] = $e;
}

function displaySiteErrors()
{
    if(!empty($_SESSION['frame']['site_errors'])) {

        $html = '<div id="frame-site-notifications">';

        foreach ($_SESSION['frame']['site_errors'] as $error) {

            $html .= '<div class="error">';
            $html .= $error;
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;

    } else {
        return '';
    }
}

function addFieldErrors($fields)
{
    if (is_array($fields)) {
        foreach ($fields as $field) {
            $_SESSION['frame']['invalid_fields'][] = $field;
        }
    } else {
        $_SESSION['frame']['invalid_fields'][] = $fields;
    }

}

function getFieldErrors()
{
    return empty($_SESSION['frame']['invalid_fields']) ? [] : $_SESSION['frame']['invalid_fields'];
}


function resolveUploadPath($hash, $type)
{
    if ($type == 'image') {
        $baseDir = IMAGE_DIR;
        $ext = '.jpg';
    } else if ($type == 'track') {
        $baseDir = TRACK_DIR;
        $ext = '.mp3';
    } else if ($type == 'pcm') {
        $baseDir = PCM_DIR;
        $ext = '.html';
    } else if ($type == 'comment') {
        $baseDir = COMMENT_DIR;
        $ext = '.html';
    } else if ($type == 'view') {
        $baseDir = VIEW_DIR;
        $ext = '.html';
    } else {
        return false;
    }

    $level1 = substr($hash, 0, 1);
    $level2 = substr($hash, 1, 2);
    $level3 = substr($hash, 3, 4);

    if (!file_exists($baseDir . DS . $level1)) {
        mkdir($baseDir . DS . $level1);
    }
    if (!file_exists($baseDir . DS . $level1 . DS . $level2)) {
        mkdir($baseDir . DS . $level1 . DS . $level2);
    }
    if (!file_exists($baseDir . DS . $level1 . DS . $level2 . DS . $level3)) {
        mkdir($baseDir . DS . $level1 . DS . $level2 . DS . $level3);
    }

    return $baseDir . DS . $level1 . DS .$level2 . DS . $level3 . DS . $hash . $ext;

}


/** Main Call Function **/
function hook()
{

//    echo '<pre>';
//    $user = User::findOne(['username' => 'esser32@gmail.com']);
//    $api = $user->getApi();
//
////    $user->getApis();
////    $api = Api::findOne(['user_id' => $user->id]);
//
//
//    var_dump($user);
//    var_dump($api);
//    die;

    // load the router
    $router = new Router();
    $router->setBasePath(BASE_PATH);
    include_once (ROOT . DS . 'app' . DS . 'routes.php');

    // get the request
    $request = BASE_PATH . '/' . str_replace('_url=', '', $_SERVER['QUERY_STRING']);
    if(substr($request, -1) == '/') {
        $request = substr($request, 0, -1);
    }


    $method = $_SERVER['REQUEST_METHOD'];
    $match = $router->match($request, $method);

    try {

        if ($match === false) {

            throw new Exception();

        } else {

            list($controller, $action) = explode('#', $match['target']);

            $controllerName = $controller;
            $controller = str_replace('Controller', '', $controller);

            if (class_exists($controllerName)) {

                $dispatch = new $controllerName($controller, $action);

                if (method_exists($dispatch, $action)) {

                    if (method_exists($controllerName, 'beforeAction')) {
                        call_user_func_array([$dispatch, 'beforeAction'], $match['params']);
                    }

                    call_user_func_array([$dispatch, $action], $match['params']);

                    if (method_exists($controllerName, 'afterAction')) {
                        call_user_func_array([$dispatch, 'afterAction'], $match['params']);
                    }

                } else {

                    throw new Exception();
                }

            }

        }

    } catch (Exception $e) {
        http_response_code(404);
        die();

    }


}


gzipOutput() || ob_start("ob_gzhandler");

$cache = new Cache();
$inflect = new Inflection();

setReporting();
removeMagicQuotes();
unregisterGlobals();
hook();
