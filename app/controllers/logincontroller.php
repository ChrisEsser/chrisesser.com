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

        // check for a user with this username
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
        if (!Auth::setLoggedInUser($user->id)) {
            addSiteError('An error occurred logging in.');
            Redirect::back();
        }


        // if remember me is selected
        if (!empty($_POST['remember']) && $_POST['remember'] == 1) {

            $selector = Auth::generateToken();
            $validator = hash('sha256', $selector);

            if (!$authToken = AuthToken::findOne(['user_id' => $user->id])) {
                $authToken = new AuthToken();
            }

            $authToken->user_id = $user->id;
            $authToken->selector = $selector;
            $authToken->validator = $validator;
            $authToken->expires = 'DATE_ADD(UTC_DATETIME, INTERVAL 1 YEAR)';

            // try to save the token & cookie
            try {
                $authToken->save();
                setcookie('login', $selector, time()+31556926, '/');
            } catch(Exception $e){
                var_dump($e);
                die;
            }
        }

        Redirect::backTwo();

    }

    public function logout()
    {
        $this->render = 0;

        Auth::logoutProcess();
        Redirect::to(BASE_PATH);
    }

}
