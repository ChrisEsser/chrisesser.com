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
    public $bchBalance;
    public $ethBalance;
    public $ltcBalance;
    public $btcUsd;
    public $ethUsd;
    public $ltcUsd;
    public $cbAccounts;
    public $otherAccounts;

    protected $testMode;


    /**
     * run before every page load
     */
    public function beforeAction()
    {

        $this->testMode = getenv('DEVELOPMENT_ENVIRONMENT');
        if ($this->testMode == 'true') $this->testMode = true;
        else $this->testMode = false;


        // check for logged in user
        $loggedInUser = Auth::loggedInUser();
        if (!$loggedInUser) Redirect::to(BASE_PATH . '/login');
        $this->loggedInUser = $loggedInUser;

        $keys = new stdClass();
        if ($this->testMode) {
            // get test keys
            $keys->api_key = getenv('TEST_KEY');
            $keys->secret = getenv('TEST_SECRET');
            $keys->phrase = getenv('TEST_PHRASE');

        } else {
            // check for this user's gdax api keys
            $keys = Api::findOne(['user_id' => $this->loggedInUser['id']]);
        }

        // dont need to load gdax api on these actions
        $noAPIActions = ['settings', 'settings_save', 'add_account', 'add_accounts'];

        // setup the gdax exchange object if we are not on the settings page
        if (!in_array($this->_action, $noAPIActions)) {

            if (empty($keys)) {
                addSiteError('No GDAX API key configured yet.');
                Redirect::to(BASE_PATH . '/trade/settings');
            }

            // load the exchange api
            $this->exchange = new GDAXExchange\Exchange($this->testMode);

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

        if (!$this->getAccounts('all')) {
            addSiteError($this->accounts['body']);
            Redirect::to(BASE_PATH . '/trade/settings');
        }

        $this->getBalance('all', 'all');

        $this->set('accounts', $this->accounts);
        $this->set('usdBalance', $this->usdBalance);
        $this->set('btcBalance', $this->btcBalance);
        $this->set('bchBalance', $this->bchBalance);
        $this->set('ethBalance', $this->ethBalance);
        $this->set('ltcBalance', $this->ltcBalance);

    }

    /**
     *  accounts page
     */
    public function accounts()
    {

        // gdax / coinbase accounts
        if (!$this->getAccounts('all')) {
            addSiteError($this->accounts['body']);
            Redirect::to(BASE_PATH . '/trade/settings');
        }

        // check for manual accounts
        $otherAccounts = Account::find(['user_id' => $this->loggedInUser['id']]);

        $this->getBalance('all', 'all');

        $this->set('accounts', $this->accounts);
        $this->set('otherAccounts', $otherAccounts);
        $this->set('cbAccounts', $this->cbAccounts);
        $this->set('usdBalance', $this->usdBalance);
        $this->set('btcBalance', $this->btcBalance);
        $this->set('ethBalance', $this->ethBalance);
        $this->set('ltcBalance', $this->ltcBalance);
        $this->set('btcUsd', $this->exchange->ticker('BTC-USD')['price'] ?: 0);
        $this->set('ethUsd', $this->exchange->ticker('ETH-USD')['price'] ?: 0);
        $this->set('ltcUsd', $this->exchange->ticker('LTC-USD')['price'] ?: 0);

    }

    public function account($type, $currency)
    {

        $this->set('type', $type);
        $this->set('currency', $currency);

    }

    public function remove_account()
    {
        $type = (!empty($_POST['type'])) ? $_POST['type'] : '';
        $currency = (!empty($_POST['account'])) ? $_POST['account'] : '';

        if ($account = Account::findOne([
            'user_id' => $this->loggedInUser['id'],
            'market_name' => $currency,
            'type' => 'manual'
        ])) {
            $account->delete();
        }

        Redirect::to(BASE_PATH . '/trade/accounts');

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
     * add manual account page
     */
    public function add_accounts()
    {

        // get a list of available accounts from bitrex
        $url = 'https://bittrex.com/api/v1.1/public/getmarkets';
        $tmpMarkets = json_decode(file_get_contents($url));
        $tmpMarkets = $tmpMarkets->result;


        // find any markets already added
        $checked = [];
        foreach ($tmpMarkets as &$tmpMarket) {

            if (!Account::findOne(['user_id' => $this->loggedInUser['id'], 'market_name' => $tmpMarket->MarketCurrency])
                && $tmpMarket->MarketCurrency != 'USDT'
                && !in_array($tmpMarket->MarketCurrency, $checked)) {

                $checked[] = $tmpMarket->MarketCurrency;
                $markets[] = $tmpMarket;

            }
        }


        $this->set('markets', $markets);

    }


    public function add_account()
    {

        //  add an account via ajax
        $this->render = 0;
        header('Content-Type: application/json');

        $market = (!empty($_POST['currency'])) ? $_POST['currency'] : '';
        $balance = (!empty($_POST['balance'])) ? $_POST['balance'] : 0;

        if (Account::findOne(['user_id' => $this->loggedInUser['id'], 'market_name' => $market])) {
            echo json_encode(['result' => 'success', 'message' => 'Coin already added']);
            die;
        }

        if (empty($market)) {
            echo json_encode(['result' => 'error', 'message' => 'No currency was selected.']);
            die;
        }

        // add the account
        $account = new Account();
        $account->user_id = $this->loggedInUser['id'];
        $account->type = 'manual';
        $account->market_name = $market;
        $account->balance = $balance;

        try {
            $account->save();
        } catch (Exception $e) {
            echo json_encode(['result' => 'error', 'message' => 'There was an error saving adding the account']);
            die;
        }


        echo json_encode(['result' => 'success', 'message' => 'Coin successfully added']);
        die;

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


        // check for an existing record
        if (!$api = Api::findOne(['user_id' => $this->loggedInUser['id']])) {
            $api = new Api();
            $api->user_id = $this->loggedInUser['id'];
        }

        // set the values
        $api->api_key = $_POST['api_key'];
        $api->secret = $_POST['secret'];
        $api->phrase = $_POST['phrase'];


        try {
            $api->save();
        } catch (Exception $e) {
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

        // coinbase accounts
        if ($type == 'other' || $type == 'all') {
//            $this->otherAccounts = $this->getOtherAccounts();
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
                    } else if ( $account['currency'] == 'BCH' && ($currency == 'bch' || $currency == 'all')) {
                        $this->bchBalance = $account['balance'];
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
                } else if ( $account['currency'] == 'BCH' && ($currency == 'bch' || $currency == 'all')) {
                    $this->bchBalance = $account['balance'];
                }
            }
        }

        // manual balances
        if (!empty($this->cbAccounts) && ($type == 'other' || $type == 'all')) {
            foreach (Account::find(['user_id' => $this->loggedInUser['id']]) as $account) {

                if ($account->market_name == 'ETH') $name = 'ethereum';
                elseif ($account->market_name == 'BTC') $name = 'bitcoin';
                elseif ($account->market_name == 'LTC') $name = 'litecoin';
                elseif ($account->market_name == 'XRP') $name = 'ripple';
                elseif ($account->market_name == 'XLM') $name = 'stellar';
                else break;

                $result = json_decode(file_get_contents('https://api.coinmarketcap.com/v1/ticker/' . $name));
                $this->usdBalance += $result[0]->price_usd * $account->balance;
            }
        }

        return true;

    }

}
