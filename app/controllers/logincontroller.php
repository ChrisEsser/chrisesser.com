<?php

class LoginController extends BaseController
{

    public function beforeAction()
    {

    }

    public function login()
    {

    }

    public function auth()
    {
        $this->render = 0;

        $user = new User();
        $user->where('username', $_POST['email']);
        $user->setLimit(1);
        $user = $user->search();

        if (empty($user)) {
            addSiteError('That email does not exist');
            Redirect::back();

        }

        if (!password_verify($_POST['password'], $user[0]['user']['password'])) {
            addSiteError('Invalid password');
            Redirect::back();
        }


        $_SESSION['frame']['auth']['loggedInUser'] = [
            'id' => $user[0]['user']['id'],
            'username' => $user[0]['user']['username'],
        ];
        Redirect::backTwo();

    }

    public function logout()
    {

    }

}
