<?php

use ChrisEsser\GDAXExchange;

$exchange = new GDAXExchange\Exchange();

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

$btcUsd = $exchange->ticker('BTC-USD')['price'];
$ethUsd = $exchange->ticker('ETH-USD')['price'];
$ltcUsd = $exchange->ticker('LTC-USD')['price'];

$btcBalance += 0.01325925;
//$balance += 58.34;


?>

<style>
    .buy-btn-group {
        display: flex;
        margin: auto;
        margin-bottom: 15px;
    }

    .buy-btn-group button {
        flex: 1;
        border: 1px solid #3A444D;
        background-color: transparent;
        padding: 3px;
        font-size: 11px;
        font-weight: 500;
    }

    .buy-btn-group button.active {
        background-color: #3A444D;
        color: #fff;
    }


    .toggle-switch-input {
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
        margin: 0;
        margin-bottom: 10px;
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
        margin-bottom: 10px;
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

    .input-group-addon {
        background-color: transparent;
        border-left: none;
    }


    .line-rule {
        color: #838A8F;
        background-color: #838A8F;
        height: 2px;
        width: 100%;
        margin: 10px 0;
    }

    .total-row {
        display:  flex;
        margin-top: -7px;
    }

    .total-row div {
        flex: 1
    }

    .total-row div:first-child {
        text-align: left;
    }
    .total-row div:last-child {
        text-align: right;
    }

    .form-control:focus {
        border: 1px solid #ccc;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .order-book-snapshot {
        background-color: transparent;
        width: 100%;
        margin-bottom: 15px;
    }

    .order-book-snapshot div {
        padding: 0;
        color: white;
        font-size: 9px;
    }

    #order-book-snapshot-price {
        float: right;
        text-align: right;
        font-size: 14px;
        color: #3A444D;
    }

    #order-book-buys {
        background-color: #4DA53C;
        width: 1%;
    }
    #order-book-sells {
        background-color: #FF6939;
        width: 1%;
    }

    #error-message {
        display: none;
        position: relative;
        background: #f2dede;
        color: #a94442;
        line-height: 22px;
        font-size: 15px;
        padding: 10px 10px 10px 50px;
        word-wrap: break-word;
        border: 1px solid #a94442;
        margin: 10px 0;
        border-radius: 3px;
    }

    #error-message:before {
        content: '\f06a';
        font-family: "FontAwesome";
        color: #FFFFFF;
        position: absolute;
        top: 50%;
        margin-top: -11px;
        font-size: 28px;
        font-style: normal;
        font-weight: 400;
        left: 8px;
        line-height: 22px;
        z-index: 1;
    }

    #error-message:after {
        content: '';
        height: 100%;
        left: 0;
        position: absolute;
        top: 0;
        width: 40px;
        background: #a94442;
    }

    .buy-columns {
        width: 50%;
        display: inline-block;
        padding: 0;
        float: left;
    }
    .column-left {
        padding-right: 7px;
    }
    .column-right {
        padding-left: 7px;
    }


    @media (max-width: 768px) {
        .buy-columns {
            width: 100%;
            display: block;
            float: none;
            padding: 0;
        }
        .column-right {
            margin-top: 20px;
        }
    }

    .orders-header {
        padding: 15px;
        background-color: #5D656C;
        color: #FFFFFF;
        margin: -15px -15px 0;
        border-top-right-radius: 4px;
        border-top-left-radius: 4px;
    }

    .orders-header div {
        display: inline-block;
    }

    .orders-header div:first-child {
        font-size: 17px;
        font-weight: 600;
        margin: 0;
    }

    .orders-header div:nth-child(2) {
        font-size: 14px;
        font-weight: 600;
        margin: 0;
        float: right;
    }

    .orders-header div:nth-child(2) a {
        text-decoration: underline;
        color: #FFFFFF;
    }

    .orders-header div:nth-child(2) a:nth-child(2) {
        color: #A8B2B5;
    }







</style>

<div class="small-top-bar"><span id="order-label">Buy</span> <span id="coin-label">Bitcoin</span></div>
<div class="top-gap-fix"></div>


<div class="container">

    <div class="buy-btn-group" role="group">
        <button class="active" type="button">BTC-USD</button>
        <button type="button">ETH-USD</button>
        <button type="button">ETH-BTC</button>
        <button type="button">LTC-USD</button>
        <button type="button">LTC-BTC</button>
    </div>

    <div class="clearfix"></div>

    <div class="buy-columns column-left">

        <div class="buy-balance-container panel">
            <div class="panel-body">
                <h4>BALANCE</h4>
                <div style="margin-top: 7px;" class="row">
                    <div class="col-xs-6" id="conversion-label">USD</div>
                    <div class="col-xs-6" id="conversion-value" role="button" style="text-align: right;"><?=number_format($balance, 2)?></div>
                </div>
                <div style="margin-top: 7px;" class="row">
                    <div class="col-xs-6" id="balance-currency-label" style="width: 50%; display: inline-block">BTC</div>
                    <div class="col-xs-6" id="balance-value" role="button"  style="text-align: right;"><?=number_format((float)$btcBalance, 8)?></div>
                </div>
            </div>
        </div>


        <div class="order-book-snapshot">
            <div id="order-book-snapshot-price">0.0</div>
            <div id="order-book-sells" role="button" ></div>
            <div id="order-book-buys" role="button"></div>
        </div>

        <div class="buy-balance-container panel">

            <div class="panel-body">

                <ul class="order-type-list">
                    <li class="order-type-item active">MARKET</li>
                    <li class="order-type-item">LIMIT</li>
                    <li class="order-type-item">STOP</li>
                </ul>

                <ul class="buy-sell-btn">
                    <li class="buy-sell-btn-item buy buy-active">BUY</li>
                    <li class="buy-sell-btn-item sell">SELL</li>
                </ul>

    <!--    <div>-->
    <!--        <span style="color: green" id="test-buys"></span>&emsp;-->
    <!--        <span style="color: red" id="test-sells"></span>-->
    <!--    </div>-->


                <form id="orderForm" name="orderForm" method="POST">

                    <input type="hidden" id="side" name="side" value="buy" />
                    <input type="hidden" id="currency" name="currency" value="BTC-USD" />
                    <input type="hidden" id="type" name="type" value="MARKET" />

                    <!-- amount -->
                    <div class="form-group" id="form-amount-row">
                        <label class="control-label" for="amount">Amount</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="amount" id="amount" placeholder="0.00" style="border-right: none" />
                            <span class="input-group-addon">USD</span>
                        </div>
                    </div>

                    <!-- price -->
                    <div class="form-group" id="form-price-row" style="display: none">
                        <label class="control-label" for="amount">Limit Price</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="price" id="price" placeholder="0.00" style="border-right: none" />
                            <span class="input-group-addon">USD</span>
                        </div>
                    </div>

                    <div id="advanced-row" style="display: none;">

                        <div id="advanced-row-trigger"><i class="fa fa-chevron-right"></i> Advanced</div>

                        <div id="advanced-content" style="display: none;">

                            <hr class="line-rule" />

                            <!-- policy -->
                            <div class="form-group" id="policy-row" style="display: none">
                                <label class="control-label" for="policy">Time in Force Policy</label>
                                <select class="form-control" name="policy" id="policy">
                                    <option value="GTC">Good Till Cancelled</option>
                                    <option value="GTT">Good Till Time</option>
                                    <option value="IOC">Immediate or Cancel</option>
                                    <option value="FOK">Fill or Kill</option>
                                </select>
                            </div>

                            <!-- limit-price -->
                            <div class="form-group" id="stop-limit-price" style="display: none">
                                <label class="control-label" for="limit-price">Limit Price</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="limit-price" id="limit-price" placeholder="0.00" style="border-right: none" />
                                    <span class="input-group-addon">USD</span>
                                </div>
                            </div>

                            <!-- cancel_after -->
                            <div class="form-group" id="cancel_after-row" style="display: none">
                                <label class="control-label" for="cancel_after">Cancel After</label>
                                <select class="form-control" name="cancel_after" id="cancel_after">
                                    <option value="min">One Minute</option>
                                    <option value="hour">One Hour</option>
                                    <option value="day">One Day</option>
                                </select>
                            </div>


                            <div class="checkbox" id="post-chek-row" style="">
                                <label><input type="checkbox" name="post_only" id="post_only" value="1" checked />Post Only</label>
                            </div>

                        </div>

                    </div>

                </form>

                <hr class="line-rule" />

                <div class="total-row">
                    <div>Total (<span id="total-label">BTC</span>)</div>
                    <div id="total-value">0.00</div>
                </div>


                <button type="button" class="buy-sell-submit-btn buy-active" id="place-order" style="margin-top: 15px">Place <span id="order-type">buy</span> order</button>


                <div id="error-message">
                    <div class="pull-right" role="button" >X</div>
                    <span></span>
                </div>

            </div>

        </div>


    </div>

    <div class="buy-columns column-right">

        <div class="buy-balance-container panel">
            <div class="panel-body">

                <div class="orders-header">
                    <div>OPEN ORDERS</div>
                    <div><a role="button" data-type="open">Orders</a>&emsp;<a  role="button" data-type="filled">Fills</a> </div>
                </div>

                <table class="table" id="orders-table">
                    <thead>
                        <tr>
                            <th>Size</th>
                            <th>Filled (<span id="orders-filled-label">BTC</span>)</th>
                            <th>Price (<span id="orders-price-label">USD</span>)</th>
                            <th>Fee (<span id="orders-fee-label">USD</span>)</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6"><div class="well">No open orders</div></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table" id="fills-table" style="display: none">
                    <thead>
                    <tr>
                        <th>Size (<span id="fills-size-label">BTC</span>)</th>
                        <th>Price (<span id="fills-price-label">USD</span>)</th>
                        <th>Fee (<span id="fills-fee-label">USD</span>)</th>
                        <th>Time</th>
                        <th>Product</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5"><div class="well">No filled orders</div></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>



<script>

    $(document).ready(function() {
        
        var side = 'buy';
        var currency = 'BTC-USD';
        var type = 'MARKET';
        var lastBid = 0.0;
        var lastAsk = 0.0;
        var lastMatch = {
            'BTC-USD': 0.0,
            'ETH-USD': 0.0,
            'ETC-USD': 0.0,
            'ETH-BTC': 0.0,
            'LTC-BTC': 0.0
        };
    
        chanceScreen(side, currency, type);
    
        function chanceScreen(side, currency, type) {
            clearForm();
            changeBuySell(side);
            changeCurrency(currency);
            changeOrderType(type);
            changeTotalLabels();
            changeTotal();
        }

        function clearForm() {
            $('#amount').val('');
            $('#price').val('');
            $('#limit-price').val('');
            $('#policy').val('GTC');

            if ($('#policy').val() == 'IOC' || $('#policy').val() == 'FOK') {
                $('#post_only').attr('checked', false);
                $('#post_only').attr('disabled', true);
            } else {
                $('#post_only').attr('checked', true);
                $('#post_only').removeAttr('disabled');
            }
        }
    
        function changeBuySell (newSide) {
            if (newSide != side) {
                side = newSide;
                if (side == 'buy') {
                    $('.buy-sell-btn-item:first-child').addClass('buy-active');
                    $('.buy-sell-btn-item:last-child').removeClass('sell-active');
                    $('#order-type').text('buy');
                    $('#order-label').text('Buy');
                    $('.buy-sell-submit-btn').toggleClass('buy-active sell-active');
                } else if (side == 'sell') {
                    $('.buy-sell-btn-item:last-child').addClass('sell-active');
                    $('.buy-sell-btn-item:first-child').removeClass('buy-active');
                    $('#order-type').text('sell');
                    $('#order-label').text('Sell');
                    $('.buy-sell-submit-btn').toggleClass('buy-active sell-active');
                    $('#form-amount-row').find('span').text(currency);
                }
                $('#side').val(side);
                changeTotalLabels();
            }
        }

        function changeTotalLabels() {

            if ((type == 'MARKET' && side == 'buy' && currency == 'BTC-USD')
                || (type == 'MARKET' && side == 'buy' && currency == 'ETH-USD')
                || (type == 'MARKET' && side == 'buy' && currency == 'LTC-USD')
                || (type == 'STOP' && side == 'buy' && currency == 'BTC-USD')
                || (type == 'STOP' && side == 'buy' && currency == 'ETH-USD')
                || (type == 'STOP' && side == 'buy' && currency == 'LTC-USD')) {
                $('#form-amount-row').find('span').text('USD');
            } else if ((type == 'MARKET' && side == 'sell' && currency == 'BTC-USD')
                || (type == 'LIMIT' && currency == 'BTC-USD')
                || (type == 'STOP' && side == 'buy' && currency == 'ETH-BTC')
                || (type == 'STOP' && side == 'buy' && currency == 'LTC-BTC')
                || (type == 'STOP' && side == 'sell' && currency == 'BTC-USD')) {
                $('#form-amount-row').find('span').text('BTC');
            } else if ((type == 'MARKET' && side == 'sell' && currency == 'ETH-USD')
                || (type == 'LIMIT' && currency == 'ETH-USD')
                || (type == 'LIMIT' && currency == 'ETH-BTC')
                || (type == 'STOP' && side == 'sell' && currency == 'ETH-USD')
                || (type == 'STOP' && side == 'sell' && currency == 'ETH-BTC')) {
                $('#form-amount-row').find('span').text('ETH');
            } else if ((type == 'MARKET' && side == 'sell' && currency == 'LTC-USD')
                || (type == 'LIMIT' && currency == 'LTC-USD')
                || (type == 'LIMIT' && currency == 'LTC-BTC')
                || (type == 'STOP' && side == 'sell' && currency == 'LTC-USD')
                || (type == 'STOP' && side == 'sell' && currency == 'LTC-BTC')) {
                $('#form-amount-row').find('span').text('LTC');
            }

            if ((type == 'MARKET' && side == 'sell' && currency == 'BTC-USD')
                || (type == 'MARKET' && side == 'sell' && currency == 'ETH-USD')
                || (type == 'MARKET' && side == 'sell' && currency == 'LTC-USD')
                || (type == 'LIMIT' && currency == 'BTC-USD')
                || (type == 'LIMIT' && currency == 'ETH-USD')
                || (type == 'LIMIT' && currency == 'LTC-USD')
                || (type == 'STOP' && side == 'sell' && currency == 'BTC-USD')
                || (type == 'STOP' && side == 'sell' && currency == 'ETH-USD')
                ||type == 'STOP' && side == 'sell' && currency == 'LTC-USD') {
                $('#total-label').text('USD');
            } else if ((type == 'MARKET' && side == 'buy' && currency == 'BTC-USD')
                || (type == 'LIMIT' && currency == 'ETH-BTC')
                || (type == 'LIMIT' && currency == 'LTC-BTC')
                || (type == 'STOP' && side == 'buy' && currency == 'BTC-USD')
                || (type == 'STOP' && side == 'sell' && currency == 'ETH-BTC')
                || (type == 'STOP' && side == 'sell' && currency == 'LTC-BTC')) {
                $('#total-label').text('BTC');
            } else if ((type == 'MARKET' && side == 'buy' && currency == 'ETH-USD')
                || (type == 'STOP' && side == 'buy' && currency == 'ETH-USD')
                || (type == 'STOP' && side == 'buy' && currency == 'ETH-BTC')) {
                $('#total-label').text('ETH');
            } else if ((type == 'MARKET' && side == 'buy' && currency == 'LTC-USD')
                || (type == 'STOP' && side == 'buy' && currency == 'LTC-USD')
                ||(type == 'STOP' && side == 'buy' && currency == 'LTC-BTC')) {
                $('#total-label').text('LTC');
            }

            if ((type == 'LIMIT' && currency == 'BTC-USD')
                || (type == 'LIMIT' && currency == 'ETH-USD')
                || (type == 'LIMIT' && currency == 'LTC-USD')
                || (type == 'STOP' && side == 'buy' && currency == 'BTC-USD')
                || (type == 'STOP' && side == 'buy' && currency == 'ETH-USD')
                || (type == 'STOP' && side == 'buy' && currency == 'LTC-USD')
                || (type == 'STOP' && side == 'sell' && currency == 'BTC-USD')
                || (type == 'STOP' && side == 'sell' && currency == 'ETH-USD')
                || (type == 'STOP' && side == 'sell' && currency == 'LTC-USD')) {
                $('#form-price-row').find('span').text('USD');
            } else if ((type == 'LIMIT' && currency == 'ETH-BTC')
                || (type == 'LIMIT' && currency == 'LTC-BTC')
                || (type == 'STOP' && side == 'buy' && currency == 'ETH-BTC')
                || (type == 'STOP' && side == 'buy' && currency == 'LTC-BTC')
                || (type == 'STOP' && side == 'sell' && currency == 'ETH-BTC')
                || (type == 'STOP' && side == 'sell' && currency == 'LTC-BTC')) {
                $('#form-price-row').find('span').text('BTC');
            }

            if ((type == 'STOP' && side == 'buy' && currency == 'BTC-USD')
                || (type == 'STOP' && side == 'buy' && currency == 'ETH-USD')
                || (type == 'STOP' && side == 'buy' && currency == 'LTC-USD')
                || (type == 'STOP' && side == 'sell' && currency == 'BTC-USD')
                || (type == 'STOP' && side == 'sell' && currency == 'ETH-USD')
                || (type == 'STOP' && side == 'sell' && currency == 'LTC-USD')) {
                $('#stop-limit-price').find('span').text('USD');
            } else if ((type == 'STOP' && side == 'buy' && currency == 'ETH-BTC')
                || (type == 'STOP' && side == 'buy' && currency == 'LTC-BTC')
                || (type == 'STOP' && side == 'sell' && currency == 'ETH-BTC')
                || (type == 'STOP' && side == 'sell' && currency == 'LTC-BTC')) {
                $('#stop-limit-price').find('span').text('BTC');
            }
        }
    
        function changeCurrency(newCurrency)
        {
            if (currency != newCurrency) {
                currency = newCurrency;
                $('.buy-btn-group button').removeClass('active');
                if (currency == 'BTC-USD') {

                    $('#coin-label').text('Bitcoin');
                    $('#balance-value').text(<?=number_format($btcBalance, 8)?>);
                    $('#balance-currency-label').text('BTC');
                    $('#conversion-label').text('USD');
                    $('#conversion-value').text(<?=number_format($balance, 2)?>);

                } else if (currency == 'ETH-USD') {

                    $('#coin-label').text('Ethereum');
                    $('#balance-value').text(<?=number_format($ethBalance, 8)?>);
                    $('#balance-currency-label').text('ETH');
                    $('#conversion-label').text('USD');
                    $('#conversion-value').text(<?=number_format($balance, 2)?>);

                } else if (currency == 'LTC-USD') {

                    $('#coin-label').text('Litecoin');
                    $('#balance-value').text(<?=number_format($ltcBalance, 9)?>);
                    $('#balance-currency-label').text('LTC');
                    $('#conversion-label').text('USD');
                    $('#conversion-value').text(<?=number_format($balance, 2)?>);

                } else if (currency == 'ETH-BTC') {

                    $('#coin-label').text('Ethereum');
                    $('#balance-value').text(<?=number_format($ethBalance, 8)?>);
                    $('#balance-currency-label').text('ETH');
                    $('#conversion-label').text('BTC');
                    $('#conversion-value').text(<?=number_format($btcBalance, 8)?>);

                } else if (currency == 'LTC-BTC') {

                    $('#coin-label').text('Litecoin');
                    $('#balance-value').text(<?=number_format($ltcBalance, 8)?>);
                    $('#balance-currency-label').text('LTC');
                    $('#conversion-label').text('BTC');
                    $('#conversion-value').text(<?=number_format($btcBalance, 8)?>);

                }
                $('#coin').val(currency);
            }
        }
    
        function changeOrderType(newType) {
            if (type != newType) {
                type = newType;
                $('.order-type-item').removeClass('active');
                if (type == 'MARKET') {
                    $('.order-type-list li:first-child').addClass('active');
                    $('#form-price-row, #advanced-row, #stop-limit-price, #cancel_after-row').hide();
                } else if (type == 'LIMIT') {
                    $('.order-type-list li:nth-child(2)').addClass('active');
                    $("#form-price-row").show().children('label').first().text('Limit Price');
                    $('#advanced-row, #policy-row').show();
                    $('#stop-limit-price').hide();

                    if ($('#policy').val() == 'GTT') $('#cancel_after-row').show();
                    else $('#cancel_after-row').hide();

                    $('#form-amount-row').find('span').text(currency);
                } else if (type == 'STOP') {
                    $('.order-type-list li:last-child').addClass('active');
                    $("#form-price-row").show().children('label').first().text('Stop Price');
                    $('#advanced-row, #stop-limit-price').show();
                    $('#policy-row, #cancel_after-row').hide();
                }
                $('#type').val(type);
            }
        }
    
    
        // coin selection buttons
        $('.buy-btn-group button').click(function() {
            changeCurrency($(this).text());
            $(this).addClass('active');
            clearForm();
            changeTotalLabels();
            changeTotal();
            clearErrors();
        });
    
        // order type selection buttons
        $('.order-type-item').click(function() {
            changeOrderType($(this).text());
            clearForm();
            changeTotalLabels();
            changeTotal();
            clearErrors();
        });
    
        // buy and sell buttons
        $('.buy-sell-btn-item').click(function() {
            if ($(this).hasClass('buy') && !$(this).hasClass('buy-active')) changeBuySell('buy');
            else changeBuySell('sell');
            clearForm();
            changeTotalLabels();
            changeTotal();
            clearErrors();
        });
    
    
        // show advanced stuff
        $('#advanced-row-trigger').click(function() {
            if ($(this).children('i:first-child').hasClass('fa-chevron-right')) {
                $(this).children('i:first-child').addClass('fa-chevron-down').removeClass('fa-chevron-right')
                $('#advanced-content').slideDown(200);
            } else {
                $(this).children('i:first-child').removeClass('fa-chevron-down').addClass('fa-chevron-right');
                $('#advanced-content').slideUp(200);
            }
        });
    
    
    
        $('#balance-value').click(function() {
            if (type == 'MARKET' || type == 'STOP') changeBuySell('sell');
            $('#amount').val($(this).text());
            changeTotal();
        });
    
    
        $('#policy').change(function() {
            if ($(this).val() == 'GTT') $('#cancel_after-row').show();
            else $('#cancel_after-row').hide();
            if ($(this).val() == 'IOC' || $(this).val() == 'FOK') {
                $('#post_only').attr('checked', false);
                $('#post_only').attr('disabled', true);
            } else {
                $('#post_only').attr('checked', true);
                $('#post_only').removeAttr('disabled');
            }
        });

        function updateOrderSnapshot() {
            $.getJSON('https://api.gdax.com/products/' + currency + '/book?level=2', function(data) {

                var bidsSize = 0.0;
                var asksSize = 0.0;
                var prctBids = 0.0;
                var prctAsks = 0.0;
                var totalSize = 0.0;

                for (i = 0; i < 50; i++) {
                    totalSize += parseFloat(data.bids[i][1]) + parseFloat(data.asks[i][1]);
                }

                lastBid = data.bids[0][0];
                lastAsk = data.asks[0][0];

                bidsSize += parseFloat(data.bids[0][1]);
                bidsSize += parseFloat(data.bids[1][1]);
                bidsSize += parseFloat(data.bids[2][1]);
                bidsSize += parseFloat(data.bids[3][1]);
                bidsSize += parseFloat(data.bids[4][1]);
                bidsSize += parseFloat(data.bids[5][1]);
                bidsSize += parseFloat(data.bids[6][1]);
                bidsSize += parseFloat(data.bids[7][1]);
                bidsSize += parseFloat(data.bids[8][1]);
                bidsSize += parseFloat(data.bids[9][1]);

                asksSize += parseFloat(data.asks[0][1]);
                asksSize += parseFloat(data.asks[1][1]);
                asksSize += parseFloat(data.asks[2][1]);
                asksSize += parseFloat(data.asks[3][1]);
                asksSize += parseFloat(data.asks[4][1]);
                asksSize += parseFloat(data.asks[5][1]);
                asksSize += parseFloat(data.asks[6][1]);
                asksSize += parseFloat(data.asks[7][1]);
                asksSize += parseFloat(data.asks[8][1]);
                asksSize += parseFloat(data.asks[9][1]);


                prctBids = (Math.round(bidsSize / totalSize * 100 * 1.25)).toString() + '%';
                prctAsks = (Math.round(asksSize / totalSize * 100 * 1.25)).toString() + '%';

                $('#order-book-buys').css({width: prctBids}).text(bidsSize.toFixed(2).toString());
                $('#order-book-sells').css({width: prctAsks}).text(asksSize.toFixed(2).toString());

            });
        }

        window.setInterval(function(){
            updateOrderSnapshot()
        }, 500);

        $('#order-book-sells').click(function() {
            changeBuySell('sell');
            changeOrderType('LIMIT');
            $('#price').val(lastBid);
            changeTotal();
            clearErrors();
        });

        $('#order-book-buys').click(function() {
            changeBuySell('buy');
            changeOrderType('LIMIT');
            $('#price').val(lastAsk);
            changeTotal();
            clearErrors();
        });

        $('#conversion-value').click(function() {
            if (type == 'MARKET' || type == 'STOP') {
                if (type == 'MARKET') {
                    changeBuySell('buy');
                }
                if (currency == 'BTC-USD' || currency == 'ETH-USD' || currency == 'LTC-USD') {
                    $('#amount').val(parseFloat(<?=$balance?>).toFixed(2));
                } else if (currency == 'ETH-BTC' || currency == 'LTC-BTC') {
                    $('#amount').val(parseFloat(<?=$btcBalance?>).toFixed(8));
                }
            }
            changeTotal();
        });

        $('#amount').keyup(function() {
            changeTotal();
        });
        $('#price').keyup(function() {
            changeTotal();
        });

        function changeTotal() {

            var amount = 0.0;

            var decimals = ($('#total-label').text() == 'USD') ? 2 : 8;

            if (type == 'MARKET') {
                if (side == 'buy') amount = $('#amount').val() / lastMatch[ currency ];
                else if (side == 'sell') amount = $('#amount').val() * lastMatch[ currency ];
            } else if (type == 'LIMIT') {
                amount = $('#amount').val() * $('#price').val();
            }

            if (type != 'STOP') {
                amount = amount ? amount : 0;
                $('#total-value').text(parseFloat(amount).toFixed(decimals));
            } else {
                $('#total-value').text('N/A');
            }
        }


        var socket = new WebSocket("wss://ws-feed.gdax.com");
        socket.onopen = function() {
            var msg = {
                type: "subscribe",
                channels: [{name: 'ticker', "product_ids": ["BTC-USD", 'ETH-USD', 'LTC-USD', 'ETH-BTC', 'LTC-BTC']}]
            };
            socket.send(JSON.stringify(msg));
        };

        socket.onmessage = function(event) {

            var msg = JSON.parse(event.data);

            if (msg.product_id && msg.product_id == currency) {

                    lastMatch[ currency ] = parseFloat(msg.price);
                    var decimals = ($('#conversion-label').text() == 'USD') ? 2 : 8;
                    $('#order-book-snapshot-price').text(parseFloat(msg.price).toFixed(decimals));
            }
        };

        var $form = $('#orderForm');
        $('#place-order').click(function() {

            var url = '<?=BASE_PATH?>/trade/ajax/' + side;
            var data = $form.serialize();

            clearErrors();

            $.post(url, data, function() {
            }).done(function(result) {

                if (result.result && result.result == 'error') {

                    $('#error-message').show().find('span').text(result.message);
                    console.log(result.error_fields);

                    if (result.error_fields) {
                        for (i = 0; i < result.error_fields.length; i++) {
                            $('#' + result.error_fields[i]).closest('.form-group').addClass('has-error');
                        }
                    }

                } else if (result.result && result.result == 'success') {
                    document.location = '<?=BASE_PATH?>/trade'
                }


            }).fail(function() {
                alert('The request could not be completed.');
            });

        });

        function clearErrors() {
            $('#error-message').hide();
            $('#orderForm').children('.form-group').removeClass('has-error');
        }

        $('#error-message div:first-child').click(function() {
            clearErrors();
        });


        $('.orders-header a').click(function() {
            type = $(this).data('type');
            $('.orders-header a').css({color: '#A8B2B5'});
            if (type == 'open') {
                $('#fills-table').hide();
                $('#orders-table').show();
                $('.orders-header div:first-child').text('OPEN ORDERS');
                $(this).css({color: '#FFFFFF'});
            } else if (type == 'filled') {
                $('#orders-table').hide();
                $('#fills-table').show();
                $('.orders-header div:first-child').text('FILLED ORDERS');
                $(this).css({color: '#FFFFFF'});
            }

        });

    });


</script>