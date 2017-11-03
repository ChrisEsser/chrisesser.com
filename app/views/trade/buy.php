<?php

$exchange = new Coinexchange();
$exchange->auth('3a6d08edddfc41f3907c4e3e56450542', '413ccRY5f3kxPdi7CkJbGapoMvG6NYVdnOfHXhM2flmth5o0k4L4v02PLlB7xBcjbdplCwozgf5w0Z3iePQ1qA==', 'nj3iw1bct');
$accounts = $exchange->accounts();

$balance = $btcBalance = $ethBalance = $ltcBalance = 0;
foreach ($accounts as $account) {
    if ($account['currency'] == 'USD') {
        $balance = $account['balance'];
    } else if ($account['currency'] == 'BTC') {
        $btcBalance = $account['balance'];
    } else if ($account['currency'] == 'ETH') {
        $ethBalance = $account['balance'];
    } else if ($account['currency'] == 'LTC') {
        $ltcBalance = $account['balance'];
    }
}

$btcUsd = $exchange->ticker('BTC-USD');
$btcUsd = $btcUsd['price'];
$ethUsd = $exchange->ticker('ETH-USD');
$ethUsd = $ethUsd['price'];
$ltcUsd = $exchange->ticker('LTC-USD');
$ltcUsd = $ltcUsd['price'];

?>

<style>
    .buy-btn-group {
        display: flex;
        margin: auto;
    }

    .buy-btn-group button {
        flex: 1;
        border: 1px solid #3A444D;
        background-color: transparent;
        padding: 3px;
        font-size: 15px;
        font-weight: 500;
    }

    .buy-btn-group button.active {
        background-color: #3A444D;
        color: #fff;
    }


    .toggle-switch-input{
        height: 0;
        width: 0;
        visibility: hidden;
    }

    .toggle-switch-label {
        cursor: pointer;
        text-indent: -9999px;
        width: 48px;
        height: 24px;
        background: grey;
        display: block;
        border-radius: 100px;
        position: relative;
    }

    .toggle-switch-label:after {
        content: '';
        position: absolute;
        top: 1px;
        left: 1px;
        width: 22px;
        height: 22px;
        background: #fff;
        border-radius: 22px;
        transition: 0.3s;
    }

    .toggle-switch-input:checked + label {
        background: #bada55;
    }

    .toggle-switch-input:checked + label:after {
        left: calc(100% - 1px);
        transform: translateX(-100%);
    }

    .toggle-switch-input:active:after {
        width: 48px;
    }

    .switch-container {
        float: right;
    }
    .switch-container div {
        display: inline-block;
        height: 40px;
    }


    .buy-balance-container {
        margin-top: 8px;
        box-shadow: 0 2px 2px 0 rgba(0,0,0,0.16), 0 0 0 1px rgba(0,0,0,0.08);
        transition: box-shadow 200ms cubic-bezier(0.4, 0.0, 0.2, 1);
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .buy-balance-container h4 {
        font-size: 17px;
        font-weight: 600;
        margin: 0;
    }

    .order-type-list {
        display: flex;
        width: 100%;
        margin-bottom: 20px;
        border-bottom: 2px solid #838A8F;
        list-style: none;
        padding: 0;
    }

    .order-type-item {
        flex: 1;
        margin-bottom: -2px;
        padding: 3px;
        border-bottom: 2px solid transparent;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        user-select: none;
        transition: border-color .2s ease-in-out,color .2s ease-in-out;
        list-style: none;
        color: #838A8F;
        font-size: 14px;
    }

    .order-type-list li.active {
        /*border-bottom-color: #4DA53C;*/
        color: #fff;
        background-color: #3A444D;
    }

    .buy-sell-btn {
        display: flex;
        background-color: #404a52;
        list-style: none;
        padding-left: 0;
    }
    .buy-sell-btn:first-child {
        margin-right: 1px;
    }

    .buy-sell-btn-item {
        flex: 1;
        border-radius: 1px;
        font-size: 12px;
        font-weight: bold;
        line-height: 30px;
        text-align: center;
        color: hsla(0,0%,100%,.5);
        background-color: hsla(0,0%,100%,.15);
        cursor: pointer;
        user-select: none;
        transition: background-color .2s ease-in-out;
    }

    .buy-active {
        background-color: #4da53c;
        color: #fff;
    }
    .sell-active {
        background-color: #FF6939;
        color: #fff;
    }


    .buy-sell-submit-btn {
        width: 100%;
        height: 44px;
        margin: 0 auto;
        padding: 13px 5px;
        border-radius: 3px;
        font-size: 13px;
        font-weight: bold;
        text-align: center;
        text-transform: uppercase;
        color: #fff;
        cursor: pointer;
        transition: none;
        transition: background-color .3s;
        outline: 0 none!important;
        border: none;
        transition: all .2s ease;
    }




</style>

<div class="small-top-bar">Buy <span id="coin-label">Bitcoin</span></div>
<div class="top-gap-fix"></div>


<div class="container">

    <div class="buy-btn-group" role="group">
        <button class="active" type="button">BTC</button>
        <button type="button">ETH</button>
        <button type="button">LTC</button>
    </div>

<!--    <div class="switch-container">-->
<!--        <div style="line-height: 40px; vertical-align: middle; font-size: 15px;">Margin Trading</div>-->
<!--        <div>-->
<!--            <input type="checkbox" id="switch" class="toggle-switch-input" />-->
<!--            <label for="switch" class="toggle-switch-label">Toggle</label>-->
<!--        </div>-->
<!--    </div>-->

    <div class="clearfix"></div>

    <div class="buy-balance-container panel">
        <div class="panel-body">
            <h4>BALANCE</h4>
            <div style="margin-top: 7px;" class="row">
                <div class="col-xs-6">USD</div>
                <div class="col-xs-6" id="balance-usd-value" style="text-align: right;">$<?=number_format($btcUsd * $btcBalance, 2)?></div>
            </div>
            <div style="margin-top: 7px;" class="row">
                <div class="col-xs-6" id="balance-currency-label" style="width: 50%; display: inline-block">BTC</div>
                <div class="col-xs-6" id="balance-value" style="text-align: right;"><?=(float)$btcBalance?></div>
            </div>
        </div>
    </div>

    <ul class="order-type-list">
        <li class="order-type-item active">MARKET</li>
        <li class="order-type-item">LIMIT</li>
        <li class="order-type-item">STOP</li>
    </ul>

    <ul class="buy-sell-btn">
        <li class="buy-sell-btn-item buy buy-active">BUY</li>
        <li class="buy-sell-btn-item sell">SELL</li>
    </ul>


    <button type="submit" class="buy-sell-submit-btn buy-active">Place <span id="order-type">buy</span> order</button>

</div>



<script>


    $('.buy-btn-group button').click(function() {

        var what = $(this).text();
        $('.buy-btn-group button').removeClass('active');
        $(this).addClass('active');

        if (what == 'BTC') {
            $('#coin-label').text('Bitcoin');
            $('#balance-usd-value').text('$' + parseFloat((<?=$btcUsd?> * <?=$btcBalance?>).toFixed(2)));
            $('#balance-currency-label').text('BTC');
            $('#balance-value').text(<?=$btcBalance?>);
        } else if (what == 'ETH') {
            $('#coin-label').text('Ethereum');
            $('#balance-usd-value').text('$' + parseFloat((<?=$ethUsd?> * <?=$ethBalance?>).toFixed(2)));
            $('#balance-currency-label').text('ETH');
            $('#balance-value').text(<?=$ethBalance?>);
        } else if (what == 'LTC') {
            $('#coin-label').text('Litecoin');
            $('#balance-usd-value').text('$' + parseFloat((<?=$ltcUsd?> * <?=$ltcBalance?>).toFixed(2)));
            $('#balance-currency-label').text('LTC');
            $('#balance-value').text(<?=$ltcBalance?>);
        }

    });

    $('.order-type-item').click(function() {
        $('.order-type-item').removeClass('active');
        $(this).addClass('active');
    });

    $('.buy-sell-btn-item').click(function() {
        $('.buy-sell-btn-item').removeClass('buy-active');
        $('.buy-sell-btn-item').removeClass('sell-active');
        if ($(this).hasClass('buy')) {
            $(this).addClass('buy-active');
            $('#order-type').text('buy');
        } else if ($(this).hasClass('sell')) {
            $(this).addClass('sell-active');
            $('#order-type').text('sell');
        }
        $('.buy-sell-submit-btn').toggleClass('buy-active');
        $('.buy-sell-submit-btn').toggleClass('sell-active');
    });

</script>