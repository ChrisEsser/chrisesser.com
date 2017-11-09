<?php

class TradeController extends BaseController
{
    protected $loggedInUser;

    public function beforeAction()
    {
        $loggedInUser = Auth::loggedInUser();
//        if (!$loggedInUser) Redirect::to(BASE_PATH . '/login');
        $this->loggedInUser = $loggedInUser;

        $this->set('page', strtolower($this->_action));
    }


    public function prices()
    {

    }

    public function accounts()
    {

    }

    public function buy()
    {

    }

    public function alerts()
    {

    }

    public function settings()
    {

    }

}
