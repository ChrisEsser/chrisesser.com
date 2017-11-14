<?php


class Auth
{

    public static function loggedInUser()
    {
        if (!isset($_SESSION['frame']['auth']['loggedInUser'])) {
            return false;
        }

        return $_SESSION['frame']['auth']['loggedInUser'];
    }

    public static function setLoggedInUser($userId)
    {
        $objUser = new User();
        $objUser->id = $userId;
        $user = $objUser->search()['user'];

        $_SESSION['frame']['auth']['loggedInUser'] = [
            'id' => $user['id'],
            'slug' => $user['slug'],
            'name' => $user['name'],
        ];
    }

    public static function logoutProcess()
    {
        unset($_SESSION['frame']['auth']['loggedInUser']);
    }

}