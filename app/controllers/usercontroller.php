<?php

class UserController extends BaseController
{

    protected $loggedInUser;
    protected $isAdmin;

    public function beforeAction()
    {

        if (!$this->loggedInUser = Auth::loggedInUser()) Redirect::to(BASE_PATH . 'login');
        $this->isAdmin = Acl::isAdmin();

    }

    public function delete($userId)
    {

        $this->render = 0;

        if (empty($userId)) {
            addSiteError('Invalid user');
            Redirect::back();
        }

        if ($_POST['user'] != $this->loggedInUser['id'] && !$this->isAdmin) {
            addSiteError('Invalid security');
            Redirect::backTwo();
        }

        $user = User::findOne(['id' => $userId]);

        try {
            $user->delete();
        } catch (Exception $e) {
            addSiteError('There was an error deleted the user.');
        }

        Redirect::back();

    }

    public function save($userId = 0)
    {

        $this->render = 0;

        $missing = [];
        if (empty($_POST['username'])) {
            $missing['username'];
        }
        if (empty($_POST['password']) && empty($userId)) {
            $missing['password'];
        }

        if (!empty($missing)) {
            addFieldErrors($missing);
            Redirect::back();
        }

        if (empty($userId) && !$this->isAdmin) {
            addSiteError('Invalid security');
            Redirect::backTwo();
        }

        if (!empty($userId)) {

            $user = User::findOne(['id' => $userId]);

            if (!empty($_POST['password'])) {
                $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

        } else {

            if ((bool)User::findOne(['username' => $_POST['username']])) {
                addSiteError('That username already exists.');
                Redirect::back();
            }

            $user = new User();
            $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $user->username = $_POST['username'];
        $user->admin = ($this->isAdmin && !empty($_POST['admin'])) ? true : false;

        try {
            $user->save();
        } catch (Exception $e) {
            addSiteError('There was an error saving the user');
        }

        Redirect::backTwo();

    }

}
