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
                    <div class="col-xs-6" id="conversion-value" role="button" style="text-align: right;"><?=number_format($usdBalance, 2)?></div>
                </div>
                <div style="margin-top: 7px;" class="row">
                    <div class="col-xs-6" id="balance-currency-label" style="width: 50%; display: inline-block">BTC</div>
                    <div class="col-xs-6" id="balance-value" role="button"  style="text-align: right;"><?=number_format((float)$btcBalance, 8)?></div>
                </div>
            </div>
        </div>


        <div class="buy-balance-container panel">
            <div class="panel-body">
                <div class="order-book-snapshot">
                    <div id="order-book-snapshot-price">0.0</div>
                    <div id="order-book-sells" role="button" ></div>
                    <div id="order-book-buys" role="button"></div>
                </div>
            </div>
        </div>

        <div class="buy-balance-container panel">

            <div class="panel-body">

                <ul class="order-type-list">
                    <li class="order-type-item">MARKET</li>
                    <li class="order-type-item">LIMIT</li>
                    <li class="order-type-item">STOP</li>
                </ul>

                <ul class="buy-sell-btn">
                    <li class="buy-sell-btn-item buy ">BUY</li>
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

                        <div id="advanced-row-trigger" role="button"><i class="fa fa-chevron-right"></i> Advanced</div>

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
    
        chanceScreen(side, currency, type, true);
    
        function chanceScreen(side, currency, type, init = false) {
            clearForm();
            changeBuySell(side, init);
            changeCurrency(currency, init);
            changeOrderType(type, init);
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
            $('#order-book-snapshot-price').text(lastMatch[currency]);
        }
    
        function changeBuySell (newSide, init = false) {
            if (newSide != side || init) {
                side = newSide;
                if (side == 'buy') {
                    $('.buy-sell-btn-item:first-child').addClass('buy-active');
                    $('.buy-sell-btn-item:last-child').removeClass('sell-active');
                    $('#order-type').text('buy');
                    $('#order-label').text('Buy');
                    if (!init) { $('.buy-sell-submit-btn').toggleClass('buy-active sell-active'); }
                } else if (side == 'sell') {
                    $('.buy-sell-btn-item:last-child').addClass('sell-active');
                    $('.buy-sell-btn-item:first-child').removeClass('buy-active');
                    $('#order-type').text('sell');
                    $('#order-label').text('Sell');
                    if (!init) { $('.buy-sell-submit-btn').toggleClass('buy-active sell-active'); }
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
    
        function changeCurrency(newCurrency, init = false)
        {
            if (currency != newCurrency || init) {
                currency = newCurrency;
                if (!init) $('.buy-btn-group button').removeClass('active');
                if (currency == 'BTC-USD') {

                    $('#coin-label').text('Bitcoin');
                    $('#balance-value').text('<?=number_format($btcBalance, 8)?>');
                    $('#balance-currency-label').text('BTC');
                    $('#conversion-label').text('USD');
                    $('#conversion-value').text('<?=number_format($usdBalance, 2)?>');

                } else if (currency == 'ETH-USD') {

                    $('#coin-label').text('Ethereum');
                    $('#balance-value').text('<?=number_format($ethBalance, 8)?>');
                    $('#balance-currency-label').text('ETH');
                    $('#conversion-label').text('USD');
                    $('#conversion-value').text('<?=number_format($usdBalance, 2)?>');

                } else if (currency == 'LTC-USD') {

                    $('#coin-label').text('Litecoin');
                    $('#balance-value').text('<?=number_format($ltcBalance, 9)?>');
                    $('#balance-currency-label').text('LTC');
                    $('#conversion-label').text('USD');
                    $('#conversion-value').text('<?=number_format($usdBalance, 2)?>');

                } else if (currency == 'ETH-BTC') {

                    $('#coin-label').text('Ethereum');
                    $('#balance-value').text('<?=number_format($ethBalance, 8)?>');
                    $('#balance-currency-label').text('ETH');
                    $('#conversion-label').text('BTC');
                    $('#conversion-value').text('<?=number_format($btcBalance, 8)?>');

                } else if (currency == 'LTC-BTC') {

                    $('#coin-label').text('Litecoin');
                    $('#balance-value').text('<?=number_format($ltcBalance, 8)?>');
                    $('#balance-currency-label').text('LTC');
                    $('#conversion-label').text('BTC');
                    $('#conversion-value').text('<?=number_format($btcBalance, 8)?>');

                }
                $('#coin').val(currency);
            }
        }
    
        function changeOrderType(newType, init = false) {
            if (type != newType || init) {
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
                    $('#amount').val(parseFloat(<?=$usdBalance?>).toFixed(2));
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
                if (side == 'buy') amount = $('#amount').val() / lastMatch[currency];
                else if (side == 'sell') amount = $('#amount').val() * lastMatch[currency];
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

            if (msg.product_id) {

                lastMatch[msg.product_id] = parseFloat(msg.price);

                if (msg.product_id == currency) {
                    var decimals = ($('#conversion-label').text() == 'USD') ? 2 : 8;
                    $('#order-book-snapshot-price').text(parseFloat(msg.price).toFixed(decimals));
                }
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