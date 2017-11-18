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

        // check for a user with this usermname
        if (!$user = User::findOne(['username' => $_POST['email']])) {
            addSiteError('That email does not exist');
            Redirect::back();
        }


        // verify the password
        if (!password_verify($_POST['password'], $user->password)) {
            addSiteError('Invalid password');
            Redirect::back();
        }

        // set the logged in user
        $_SESSION['frame']['auth']['loggedInUser'] = [
            'id' => $user->id,
            'username' => $user->username,
        ];

        Redirect::backTwo();

    }

    public function logout()
    {
        $this->render = 0;

        Auth::logoutProcess();
        Redirect::to(BASE_PATH);
    }

}
