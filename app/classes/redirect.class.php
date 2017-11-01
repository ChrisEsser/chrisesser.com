<?php


class Redirect
{

    public static function back()
    {
        if (empty($_SESSION['frame']['redirect']['queue'])) {
            self::to(BASE_PATH);
        }

        $url = array_pop($_SESSION['frame']['redirect']['queue']);

        self::to($url);
    }

    public function backTwo()
    {
        if (empty($_SESSION['frame']['redirect']['queue'])) {
            self::to(BASE_PATH);
        }

        $url = array_pop($_SESSION['frame']['redirect']['queue']);
        if (empty($_SESSION['frame']['redirect']['queue'])) {
            self::to(BASE_PATH);
        }
        $url = array_pop($_SESSION['frame']['redirect']['queue']);
        if (empty($_SESSION['frame']['redirect']['queue'])) {
            self::to(BASE_PATH);
        }

        self::to($url);

    }

    public static function addToQueue($url)
    {

        // do nothing if ignore page is set
        if (!isset($_SESSION['frame']['redirect']['ignoreInQueue'])) {

            $last = '';

            // check if the queue has been initialized
            if (isset($_SESSION['frame']['redirect']['queue'])) {

                $last = end($_SESSION['frame']['redirect']['queue']);
                reset($_SESSION['frame']['redirect']['queue']);


                // make sure the most recent in que is not what we are trying to add
                if ($last != $url) {
                    $count = count($_SESSION['frame']['redirect']['queue']);
                    if($count >= 5) {
                        array_shift($_SESSION['frame']['redirect']['queue']);
                    }
                }

            }

            // add the url to the queue
            if ($last != $url) {
                $_SESSION['frame']['redirect']['queue'][] = $url;
            }
        }

        unset($_SESSION['frame']['redirect']['ignoreInQueue']);
    }

    public static function ignoreInQue()
    {
        $_SESSION['frame']['redirect']['ignoreInQueue'] = true;
    }

    public static function to($url, $statusCode = 303)
    {
        header('Location: ' . $url, true, $statusCode);
        die();
    }

    public static function getQueue()
    {
        return (!empty($_SESSION['frame']['redirect']['queue'])) ? $_SESSION['frame']['redirect']['queue'] : [];

    }

    public static function clearQueue()
    {
        unset($_SESSION['frame']['redirect']);
    }

}