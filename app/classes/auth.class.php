<?php


class Auth
{

    public static function loggedInUser()
    {

        // check for the session
        if (isset($_SESSION['frame']['auth']['loggedInUser'])) {
            return $_SESSION['frame']['auth']['loggedInUser'];
        }


        // check for the remember me cookie
        if (!empty($_COOKIE['login'])) {

            $userId = Auth::validateToken($_COOKIE['login']);

            if (self::setLoggedInUser($userId)) {
                return $_SESSION['frame']['auth']['loggedInUser'];
            }

        }

        return false;

    }

    public static function setLoggedInUser($userId)
    {

        // find the user
        if(!$user = User::findOne(['id' => $userId])) {
            return false;
        }

        // set the session
        $_SESSION['frame']['auth']['loggedInUser'] = [
            'id' => $user->id,
            'username' => $user->username,
        ];

        return true;
    }

    public static function logoutProcess()
    {

        // get the user_id
        $userId = (!empty($_SESSION['frame']['auth']['loggedInUser']['id'])) ? $_SESSION['frame']['auth']['loggedInUser']['id'] : 0;

        // unset the session
        unset($_SESSION['frame']['auth']['loggedInUser']);

        // search for a remember me cookie and remove it from auth tokens
        if (!empty($_COOKIE['login'])) {
            if ($authToken = AuthToken::findOne(['user_id' => $userId])) {
                $authToken->delete();
            }
        }

    }

    public static function generateToken($length = 20)
    {
        return bin2hex(random_bytes($length));
    }

    public static function validateToken($selector)
    {

        if (!$authToken = AuthToken::findOne(['selector' => $selector])) return false;
        $selector = hash('sha256', $selector);
        if (!hash_equals($selector, $authToken->validator)) return false;

        return $authToken->user_id;

    }

}