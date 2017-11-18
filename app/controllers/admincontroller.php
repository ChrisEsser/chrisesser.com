<?php

class AdminController extends BaseController
{
    protected $loggedInUser;

    public function beforeAction()
    {

        // check if the user is logged in and if they are an admin
        if (!$this->loggedInUser = Auth::loggedInUser()) Redirect::to(BASE_PATH . '/login');
        $user = User::findOne(['id' => $this->loggedInUser['id']]);

        if (empty($user->admin)) {
            addSiteError('Invalid security');
            Redirect::backTwo();
        }

    }

    public function admin()
    {

    }

    public function manage_users()
    {

    }

}
