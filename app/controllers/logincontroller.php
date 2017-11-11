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


        $_SESSION['frame']['auth']['loggedInUser'] = $user[0]['User'];
        Redirect::backTwo();

    }

    public function logout()
    {

    }

}
