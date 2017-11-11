<?php

use ChrisEsser\GDAXExchange;

class TradeController extends BaseController
{
    protected $loggedInUser;
    protected $exchange;
    protected $accounts;
    protected $balance;
    protected $btcBalance;
    protected $ethBalance;
    protected $ltcBalance;
    protected $btcUsd;
    protected $ethUsd;
    protected $ltcUsd;
    protected $cbAccounts;


    public function beforeAction()
    {
        $loggedInUser = Auth::loggedInUser();
        if (!$loggedInUser) Redirect::to(BASE_PATH . '/login');
        $this->loggedInUser = $loggedInUser;

        if (!$keys = $this->getUserApiKeys()) {

        }

        $this->set('page', strtolower($this->_action));

        $this->exchange = new GDAXExchange\Exchange();
        $this->exchange->auth($keys['api_key'], $keys['secret'], $keys['phrase']);

    }


    public function prices()
    {
        $this->accounts = $this->exchange->accounts();
        $this->cbAccounts = $this->exchange->accounts();

        if (!empty($this->accounts['body'])) {
            $this->accounts['body'] = str_replace('{"message":"', '', $this->accounts['body']);
            $this->accounts['body'] = str_replace('"}', '', $this->accounts['body']);

            addSiteError($this->accounts['body']);
            Redirect::to(BASE_PATH . '/trade/settings');
        }

        $this->balance = $this->btcBalance = $this->ethBalance = $this->ltcBalance = 0;
        foreach ($this->accounts as $account) {
            if ($account['currency'] == 'USD') {
                $this->balance = $account['balance'];
            } else if ($account['currency'] == 'BTC') {
                $this->btcBalance = $account['balance'];
            } else if ($account['currency'] == 'ETH') {
                $this->ethBalance = $account['balance'];
            } else if ($account['currency'] == 'LTC') {
                $this->ltcBalance = $account['balance'];
            }
        }

        $this->btcUsd = $this->exchange->ticker('BTC-USD')['price'];
        $this->ethUsd = $this->exchange->ticker('ETH-USD')['price'];
        $this->ltcUsd = $this->exchange->ticker('LTC-USD')['price'];

        $this->btcBalance += 0.01325925;

        $this->set('accounts', $this->accounts);
        $this->set('cbAccounts', $this->cbAccounts);
        $this->set('balance', $this->balance);
        $this->set('btcBalance', $this->btcBalance);
        $this->set('ethBalance', $this->ethBalance);
        $this->set('ltcBalance', $this->ltcBalance);
        $this->set('btcUsd', $this->btcUsd);
        $this->set('ethUsd', $this->ethUsd);
        $this->set('ltcUsd', $this->ltcUsd);


    }

    public function accounts()
    {
        $this->accounts = $this->exchange->accounts();
        $this->cbAccounts = $this->exchange->accounts();

        if (!empty($this->accounts['body'])) {
            addSiteError($this->accounts['body']);
            Redirect::to(BASE_PATH . '/trade/settings');
        }

        $this->balance = $this->btcBalance = $this->ethBalance = $this->ltcBalance = 0;
        foreach ($this->accounts as $account) {
            if ($account['currency'] == 'USD') {
                $this->balance = $account['balance'];
            } else if ($account['currency'] == 'BTC') {
                $this->btcBalance = $account['balance'];
            } else if ($account['currency'] == 'ETH') {
                $this->ethBalance = $account['balance'];
            } else if ($account['currency'] == 'LTC') {
                $this->ltcBalance = $account['balance'];
            }
        }

        $this->btcUsd = $this->exchange->ticker('BTC-USD')['price'];
        $this->ethUsd = $this->exchange->ticker('ETH-USD')['price'];
        $this->ltcUsd = $this->exchange->ticker('LTC-USD')['price'];

        $this->btcBalance += 0.01325925;

        $this->set('accounts', $this->accounts);
        $this->set('cbAccounts', $this->cbAccounts);
        $this->set('balance', $this->balance);
        $this->set('btcBalance', $this->btcBalance);
        $this->set('ethBalance', $this->ethBalance);
        $this->set('ltcBalance', $this->ltcBalance);
        $this->set('btcUsd', $this->btcUsd);
        $this->set('ethUsd', $this->ethUsd);
        $this->set('ltcUsd', $this->ltcUsd);

    }

    public function buy()
    {
        $this->accounts = $this->exchange->accounts();
        $this->cbAccounts = $this->exchange->accounts();

        if (!empty($this->accounts['body'])) {
            addSiteError($this->accounts['body']);
            Redirect::to(BASE_PATH . '/trade/settings');
        }

        $this->balance = $this->btcBalance = $this->ethBalance = $this->ltcBalance = 0;
        foreach ($this->accounts as $account) {
            if ($account['currency'] == 'USD') {
                $this->balance = $account['balance'];
            } else if ($account['currency'] == 'BTC') {
                $this->btcBalance = $account['balance'];
            } else if ($account['currency'] == 'ETH') {
                $this->ethBalance = $account['balance'];
            } else if ($account['currency'] == 'LTC') {
                $this->ltcBalance = $account['balance'];
            }
        }

        $this->btcUsd = $this->exchange->ticker('BTC-USD')['price'];
        $this->ethUsd = $this->exchange->ticker('ETH-USD')['price'];
        $this->ltcUsd = $this->exchange->ticker('LTC-USD')['price'];

        $this->btcBalance += 0.01325925;

        $this->set('accounts', $this->accounts);
        $this->set('cbAccounts', $this->cbAccounts);
        $this->set('balance', $this->balance);
        $this->set('btcBalance', $this->btcBalance);
        $this->set('ethBalance', $this->ethBalance);
        $this->set('ltcBalance', $this->ltcBalance);
        $this->set('btcUsd', $this->btcUsd);
        $this->set('ethUsd', $this->ethUsd);
        $this->set('ltcUsd', $this->ltcUsd);


    }

    public function alerts()
    {

    }

    public function settings()
    {

    }

    public function getUserApiKeys()
    {
        $user = new User();
        $user->id = $this->loggedInUser['id'];
        $user->showHasMany();
        $user = $user->search();

        if (!empty($user['apis'][0])) {
            return $user['apis'][0];
        }

        return false;
    }

}
