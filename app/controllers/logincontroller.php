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

        // do stuff

        $_SESSION['frame']['auth']['loggedInUser'] = [
            'id' => 1,
            'slug' => 'chris-esser',
            'name' => 'Chris Esser',
        ];


        Redirect::backTwo();


    }

    public function logout()
    {

    }

}
