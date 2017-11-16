<?php

use ChrisEsser\GDAXExchange;


/**
 * Class TradeController
 * @property Trade Trade
 */
class TradeController extends BaseController
{

    /** @var GDAXExchange\Exchange */
    public $exchange;

    protected $loggedInUser;
    public $accounts;
    public $usdBalance;
    public $btcBalance;
    public $ethBalance;
    public $ltcBalance;
    public $btcUsd;
    public $ethUsd;
    public $ltcUsd;
    public $cbAccounts;


    /**
     * run before every page load
     */
    public function beforeAction()
    {

        // check for logged in user
        $loggedInUser = Auth::loggedInUser();
        if (!$loggedInUser) Redirect::to(BASE_PATH . '/login');
        $this->loggedInUser = $loggedInUser;

        $keys = [];


        // check for this user's api keys
        $keys = Api::findOne(['user_id' => $this->loggedInUser['id']]);


        // setup the exchange object if we are not on the settings page
        if ($this->_action != 'settings' && $this->_action != 'settings_save') {

            if (empty($keys)) {
                addSiteError('No GDAX API key configured yet.');
                Redirect::to(BASE_PATH . '/trade/settings');
            }

            // load the exchange api
            $this->exchange = new GDAXExchange\Exchange();
            $this->exchange->auth($keys->api_key, $keys->secret, $keys->phrase);

        }


        // initialize balances
        $this->usdBalance = $this->btcBalance = $this->ethBalance = $this->ltcBalance = 0;


        // set view variables
        $this->set('page', strtolower($this->_action));
        $this->set('keys', $keys);

    }


    /**
     * prices page
     */
    public function prices()
    {
        if (!$this->getAccounts('gdax')) {
            addSiteError($this->accounts['body']);
            Redirect::to(BASE_PATH . '/trade/settings');
        }

        $this->getBalance('all', 'gdax');

        $this->set('accounts', $this->accounts);
        $this->set('usdBalance', $this->usdBalance);
        $this->set('btcBalance', $this->btcBalance);
        $this->set('ethBalance', $this->ethBalance);
        $this->set('ltcBalance', $this->ltcBalance);

    }

    /**
     *  accounts page
     */
    public function accounts()
    {

        if (!$this->getAccounts('all')) {
            addSiteError($this->accounts['body']);
            Redirect::to(BASE_PATH . '/trade/settings');
        }

        $this->getBalance('all', 'all');

        $this->set('accounts', $this->accounts);
        $this->set('cbAccounts', $this->cbAccounts);
        $this->set('usdBalance', $this->usdBalance);
        $this->set('btcBalance', $this->btcBalance);
        $this->set('ethBalance', $this->ethBalance);
        $this->set('ltcBalance', $this->ltcBalance);
        $this->set('btcUsd', $this->exchange->ticker('BTC-USD')['price'] ?: 0);
        $this->set('ethUsd', $this->exchange->ticker('ETH-USD')['price'] ?: 0);
        $this->set('ltcUsd', $this->exchange->ticker('LTC-USD')['price'] ?: 0);

    }

    /**
     * buy page
     */
    public function buy()
    {

        if (!$this->getAccounts('gdax')) {
            addSiteError($this->accounts['body']);
            Redirect::to(BASE_PATH . '/trade/settings');
        }

        $this->getBalance('all', 'gdax');

        $this->set('accounts', $this->accounts);
        $this->set('usdBalance', $this->usdBalance);
        $this->set('btcBalance', $this->btcBalance);
        $this->set('ethBalance', $this->ethBalance);
        $this->set('ltcBalance', $this->ltcBalance);

    }

    /**
     * alerts page
     * TODO: may change this to a charts page
     */
    public function alerts()
    {

    }

    /**
     * settings page
     */
    public function settings()
    {

    }

    /**
     * save trade settings
     */
    public function settings_save()
    {
        $this->render = 0;

        $missing = [];

        if (empty($_POST['api_key'])) $missing[] = 'api_key';
        if (empty($_POST['secret'])) $missing[] = 'secret';
        if (empty($_POST['phrase'])) $missing[] = 'phrase';

        if (!empty($missing)) {
            addSiteError('Required fields are missing');
            Redirect::back();
        }

        $api = new Api();
        $api->where('user_id', $this->loggedInUser['id']);
        $api = $api->search();

        if (!empty($api)) {
            $id = $api[0]['api']['id'];
        }

        $api = new Api();

        if (!empty($api)) {
            $api->id = $id;
        }

        $api->user_id = $this->loggedInUser['id'];
        $api->api_key = $_POST['api_key'];
        $api->secret = $_POST['secret'];
        $api->phrase = $_POST['phrase'];

        if (!$api->save()) {
            addSiteError('There was an error saving the API settings.');
            Redirect::back();
        }

        Redirect::backTwo();

    }

    /**
     * Get the logged in user's api keys
     *
     * @param int $userId
     * @return bool
     */
    public function getUserApiKeys($userId)
    {
        if (empty($userId)) return false;

        return  User::findOne(['id' => $userId])->getApi();

    }

    /**
     * @param string $type
     * @return bool
     */
    public function getAccounts($type = 'all')
    {
        if (empty($this->exchange)) return false;

        // gdax accounts
        if ($type == 'gdax' || $type == 'all') {
            $this->accounts = $this->exchange->accounts();
        }

        // coinbase accounts
        if ($type == 'cb' || $type == 'all') {
            $this->cbAccounts = $this->exchange->coinbase_accounts();
        }

        // check response
        if (!empty($this->accounts['body']) && !empty($this->cbAccounts['body'])) {
            $this->accounts['body'] = str_replace('{"message":"', '', $this->accounts['body']);
            $this->accounts['body'] = str_replace('"}', '', $this->accounts['body']);
            return false;
        }

        if (!empty($this->cbAccounts['body'])) {
            $this->cbAccounts = [];
        }


        return true;
    }

    /**
     * @param string $currency
     * @param string $type
     * @return bool
     */
    public function getBalance($currency = 'all', $type = 'all')
    {

        if (empty($this->accounts)) return false;


        // GDAX balances
        if ($type == 'gdax' || $type == 'all') {
            foreach ($this->accounts as $account) {
                if (!empty($account['currency'])) {
                    if ($account['currency'] == 'USD' && ($currency == 'usd' || $currency == 'all') ) {
                        $this->usdBalance = $account['balance'];
                    } else if ( $account['currency'] == 'BTC' && ($currency == 'btc' || $currency == 'all') ) {
                        $this->btcBalance = $account['balance'];
                    } else if ( $account['currency'] == 'ETH' && ($currency == 'eth' || $currency == 'all') ) {
                        $this->ethBalance = $account['balance'];
                    } else if ( $account['currency'] == 'LTC' && ($currency == 'ltc' || $currency == 'all')) {
                        $this->ltcBalance = $account['balance'];
                    }
                }
            }
        }

        // coinbase balances
        if (!empty($this->cbAccounts) && ($type == 'cb' || $type == 'all')) {
            foreach ($this->cbAccounts as $account) {
                if ( $account['currency'] == 'USD' && ($currency == 'usd' || $currency == 'all') ) {
                    $this->usdBalance += $account['balance'];
                } else if ( $account['currency'] == 'BTC' && ($currency == 'btc' || $currency == 'all') ) {
                    $this->btcBalance += $account['balance'];
                } else if ( $account['currency'] == 'ETH' && ($currency == 'eth' || $currency == 'all') ) {
                    $this->ethBalance += $account['balance'];
                } else if ( $account['currency'] == 'LTC' && ($currency == 'ltc' || $currency == 'all')) {
                    $this->ltcBalance += $account['balance'];
                }
            }
        }


        return true;

    }

}
