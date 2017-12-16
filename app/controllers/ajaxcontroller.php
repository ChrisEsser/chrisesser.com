<?php

class AjaxController extends BaseController
{

    protected $exchange;
    protected $accounts;
    protected $usdBalance;
    protected $btcBalance;
    protected $ethBalance;
    protected $ltcBalance;
    protected $testMode;

    public function beforeAction()
    {
        $this->render = 0;
        header('Content-Type: application/json');

//        $this->testMode = getenv('DEVELOPMENT_ENVIRONMENT');
//
//        $this->exchange = new ChrisEsser\GDAXExchange\Exchange($this->testMode);
//        $this->exchange->auth('3a6d08edddfc41f3907c4e3e56450542', '413ccRY5f3kxPdi7CkJbGapoMvG6NYVdnOfHXhM2flmth5o0k4L4v02PLlB7xBcjbdplCwozgf5w0Z3iePQ1qA==', 'nj3iw1bct');
//        $this->accounts = $this->exchange->accounts();
//
//        $this->usdBalance = $this->btcBalance = $this->ethBalance = $this->ltcBalance = 0;
//        foreach ($this->accounts as $account) {
//            if ($account['currency'] == 'USD') {
//                $this->usdBalance = $account['balance'];
//            } else if ($account['currency'] == 'BTC') {
//                $this->btcBalance = $account['balance'];
//            } else if ($account['currency'] == 'ETH') {
//                $this->ethBalance = $account['balance'];
//            } else if ($account['currency'] == 'LTC') {
//                $this->ltcBalance = $account['balance'];
//            }
//        }
    }

    public function buy()
    {
        try {


            // check for required fields
            $errorFields = [];
            if (empty($_POST['side']) || $_POST['side'] != 'buy') $errorFields[] = 'side';
            if (empty($_POST['currency'])) $errorFields[] = 'currency';
            if (empty($_POST['type'])) $errorFields[] = 'type';
            if (empty($_POST['amount'])) $errorFields[] = 'amount';
            if(($_POST['type'] == 'LIMIT' || $_POST['type'] == 'STOP') && empty($_POST['price'])) $errorFields[] = 'price';
            if($_POST['type'] == 'LIMIT' && empty($_POST['policy'])) $errorFields[] = 'policy';
            if($_POST['type'] == 'LIMIT' && $_POST['policy'] == 'GTT' && empty($_POST['cancel_after'])) $errorFields[] = 'cancel_after';

            if (!empty($errorFields)) throw new Exception('Required fields are missing');


            // validate balances
            if (($_POST['type'] == 'MARKET' || $_POST['type'] == 'STOP') && $_POST['amount'] > $this->usdBalance) {
                $errorFields[] = 'amount';
            }
            elseif ($_POST['type'] == 'LIMIT' && $_POST['amount'] * $_POST['price'] > $this->usdBalance) {
                $errorFields[] = 'amount';
                $errorFields[] = 'price';
            }

            if (!empty($errorFields)) throw new Exception('You don\'t have enough money in you USD account to do this transaction');


            // now attempt to make the order
            if ($_POST['type'] == 'MARKET') {
                $result = $this->exchange->place('buy', 'market', $_POST['coin'] . '-USD', 0, 0, $_POST['amount']);
            } else if ($_POST['type'] == 'LIMIT') {
                $result = $this->exchange->place('buy', 'limit', $_POST['coin'] . '-USD', $_POST['price'], $_POST['amount'], 0, $_POST['policy'], $_POST['cancel_after'], $_POST['post_only']);
            } else if ($_POST['type'] == 'STOP') {
//                $result = $this->exchange->place('buy', 'stop', $_POST['coin'] . '-USD', $_POST['amount']);
            }


//            $side, $type, $productId, $price = 0, $size = 0, $funds = 0, $time_in_force = 'GTC', $cancel_after = 'min', $post_only = true



        } catch(Exception $e) {
            echo json_encode(['result' => 'error', 'message' => $e->getMessage(), 'error_fields' => $errorFields]);
        }

    }

    public function sell()
    {
        echo json_encode($_POST);
    }
}
