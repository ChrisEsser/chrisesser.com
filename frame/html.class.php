<?php

class HTML
{


    /**
     * @param $url
     * @return string
     */
    private static function _fetchTinyUrl($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url[0]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return '<a href="' . $data . '" target = "_blank" >' . $data . '</a>';
    }

    /**
     * @param $data
     * @return string
     */
    public static function sanitize($data)
    {
        return mysqli_real_escape_string($data);
    }

    /**
     * generate a html link anchor tag
     * @param $text
     * @param $path
     * @param null $promptTitle
     * @param string $confirmMessage
     * @return string
     * @internal param null $prompt
     */
    public static function link($text, $path, $promptTitle = null, $confirmMessage = "Are you sure?")
    {
        $path = str_replace(' ', '-', $path);

        if ($promptTitle) {
//            $data = '<a data-title="'.$promptTitle.'" data-trigger="confirmDelete" data-message="'.$confirmMessage.'" data-url="'.BASE_PATH.'/'.$path.'" style="cursor: pointer;">'.$text.'</a>';
        } else {
            $data = '<a href="' . BASE_PATH . '/' . $path . '">' . $text . '</a>';
        }

        return $data;
    }


    /**
     * @param $file
     * @return string
     */
    public static function includeJs($file)
    {
        return '<script src="' . BASE_PATH . '/js/' . $file . '.js"></script>';
    }

    /**
     * @param $file
     * @return string
     */
    public static function includeCss($file)
    {
        return '<link rel="stylesheet" href="' . BASE_PATH . '/css/' . $file . '.css">';
    }


    public static function csrf()
    {
        return '<input type="hidden" name="' . CSRF::TOKEN_NAME . '" value="' . CSRF::getToken() . '" />';
    }


    public static function displaySiteErrors()
    {
        if(!empty($_SESSION['frame']['site_errors'])) {

            $html = '<div id="frame-site-notifications">';

            foreach ($_SESSION['frame']['site_errors'] as $error) {

                $html .= '<div class="error">';
                $html .= ERROR_PRES[array_rand(ERROR_PRES)] . ' ';
                $html .= $error;
                $html .= '</div>';
            }

            $html .= '</div>';

            return $html;

        } else {
            return '';
        }
    }

    public static function includeHtml($fileNamespace)
    {
        if (file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $fileNamespace)) {
            include (ROOT . DS . 'app' . DS . 'views' . DS . $fileNamespace);
        }
    }

    public static function addScriptToHead($source)
    {
        if (empty($_SESSION['frame']['html_head']['scripts'])) {
            $_SESSION['frame']['html_head']['scripts'] = [];
        }

        if (!in_array($source, $_SESSION['frame']['html_head']['scripts'])) {
            $_SESSION['frame']['html_head']['scripts'][] = $source;
        }
    }

    public static function addStyleToHead($source)
    {
        if (empty($_SESSION['frame']['html_head']['style'])) {
            $_SESSION['frame']['html_head']['style'] = [];
        }

        if (!in_array($source, $_SESSION['frame']['html_head']['style'])) {
            $_SESSION['frame']['html_head']['style'][] = $source;
        }
    }

    public static function displayHead()
    {
        $html = '';




        if (!empty($_SESSION['frame']['html_head']['scripts'])) {
            foreach ($_SESSION['frame']['html_head']['scripts'] as $source) {
                $html .= '<script src="' . $source . '"></script>';
            }
        }

        if (!empty($_SESSION['frame']['html_head']['style'])) {
            foreach ($_SESSION['frame']['html_head']['style'] as $source) {

                $html .= '<link rel="stylesheet" href="' . $source . '">';

            }
        }

        return $html;
    }

}