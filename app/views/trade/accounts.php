<?php

    $exchange = new Coinexchange();
    $exchange->auth('3a6d08edddfc41f3907c4e3e56450542', '413ccRY5f3kxPdi7CkJbGapoMvG6NYVdnOfHXhM2flmth5o0k4L4v02PLlB7xBcjbdplCwozgf5w0Z3iePQ1qA==', 'nj3iw1bct');
    $accounts = $exchange->accounts();
    $cbAccounts = $exchange->coinbase_accounts();

    $btcUsd = $exchange->ticker('BTC-USD');
    $btcUsd = $btcUsd['price'];
    $ethUsd = $exchange->ticker('ETH-USD');
    $ethUsd = $ethUsd['price'];
    $ltcUsd = $exchange->ticker('LTC-USD');
    $ltcUsd = $ltcUsd['price'];

?>

<div class="small-top-bar">Accounts</div>
<div class="top-gap-fix"></div>


<div class="container">

    <h4 class="account-type-header">GDAX Accounts</h4>
    <ul class="list-group">
        <?php foreach($accounts as $account) { ?>

            <?php if ($account['currency'] == 'BTC') {
                $colorClass = 'btc-color';
                $icon = 'bitcoin';
                $dollarValue = $btcUsd;
            } else if ($account['currency'] == 'ETH') {
                $colorClass = 'eth-color';
                $icon = 'bitcoin';
                $dollarValue = $ethUsd;
            } else if ($account['currency'] == 'LTC') {
                $colorClass = 'ltc-color';
                $icon = 'bitcoin';
                $dollarValue = $ltcUsd;
            } else if ($account['currency'] == 'USD') {
                $colorClass = 'usd-color';
                $icon = 'usd';
            } ?>

            <li class="list-group-item accounts-row">
                <div class="accounts-left">
                    <div class="figure-container">
                        <figure class="circle <?=$colorClass?>"><i class="fa fa-<?=$icon?>"></i></figure>
                    </div>
                    <div class="account-label">
                        <?=$account['currency']?>
                    </div>
                </div>
                <div class="accounts-right">
                    <div>
                        <?=number_format($account['balance'])?><br />
                        <?php if ($account['currency'] != 'USD') { ?>
                            $<?=number_format($account['balance'] * $dollarValue, 2)?>
                        <?php } ?>
                    </div>
                    <div class="chevron-container">
                        <i class="fa fa-chevron-right"></i>
                    </div>

                </div>
            </li>

        <?php } ?>
    </ul>

    <h4 class="account-type-header">Coinbase Accounts</h4>
    <ul class="list-group">
        <?php foreach($cbAccounts as $account) { ?>

            <?php if ($account['currency'] == 'BTC') {
                $colorClass = 'btc-color';
                $icon = 'bitcoin';
                $dollarValue = $btcUsd;
            } else if ($account['currency'] == 'ETH') {
                $colorClass = 'eth-color';
                $icon = 'bitcoin';
                $dollarValue = $ethUsd;
            } else if ($account['currency'] == 'LTC') {
                $colorClass = 'ltc-color';
                $icon = 'bitcoin';
                $dollarValue = $ltcUsd;
            } else if ($account['currency'] == 'USD') {
                $colorClass = 'usd-color';
                $icon = 'usd';
            } ?>

            <li class="list-group-item accounts-row">
                <div class="accounts-left">
                    <div class="figure-container">
                        <figure class="circle <?=$colorClass?>"><i class="fa fa-<?=$icon?>"></i></figure>
                    </div>
                    <div class="account-label">
                        <?=$account['currency']?>
                    </div>
                </div>
                <div class="accounts-right">
                    <div>
                        <?=number_format($account['balance'])?><br />
                        <?php if ($account['currency'] != 'USD') { ?>
                            $<?=number_format($account['balance'] * $dollarValue, 2)?>
                        <?php } ?>
                    </div>
                    <div class="chevron-container">
                        <i class="fa fa-chevron-right"></i>
                    </div>

                </div>
            </li>
        <?php } ?>
    </ul>

</div>