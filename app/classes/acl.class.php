<?php


class Acl
{

    public static function isAdmin($userId = 0)
    {

        if (empty($userId)) {
            $user = Auth::loggedInUser();
            if (empty($user)) return false;
            $userId = $user['id'];
        }

        $user = User::findOne(['id' => $userId]);
        if ($user->admin == 1) return true;

        return false;

    }

}