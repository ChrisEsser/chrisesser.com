<?php

    $exchange = new Coinexchange();
    $exchange->auth('3a6d08edddfc41f3907c4e3e56450542', '413ccRY5f3kxPdi7CkJbGapoMvG6NYVdnOfHXhM2flmth5o0k4L4v02PLlB7xBcjbdplCwozgf5w0Z3iePQ1qA==', 'nj3iw1bct');
    $accounts = $exchange->accounts();
    $cbAccounts = $exchange->coinbase_accounts();

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

    foreach ($cbAccounts as $cbAccount) {
        if ($cbAccount['currency'] == 'USD') {
            $balance += $cbAccount['balance'];
        } else if ($cbAccount['currency'] == 'BTC') {
            $btcBalance += $cbAccount['balance'];
        } else if ($cbAccount['currency'] == 'ETH') {
            $ethBalance += $cbAccount['balance'];
        } else if ($cbAccount['currency'] == 'LTC') {
            $ltcBalance += $cbAccount['balance'];
        }
    }

$btcBalance += 0.01325925;

?>


    <div class="trade-charts-top">
        <div class="my-money-label">$<span id="current-balance"><?=number_format($balance, 2)?></span></div>
        <div class="my-account-link"><a href="<?=BASE_PATH?>/trade/accounts">Your Accounts <i class="fa fa-arrow-right"></i></a></div>
    </div>

    <div class="container chart-container">

        <div class="col-lg-12 row">
            <div class="graph-section">
                <div class="trade-graph-top-bar">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="graph-main-label">Bitcoin</div>
                            <div><i class="fa fa-circle" style="color: #F4A460"></i> BTC</div>
                        </div>
                        <div class="col-xs-6" style="text-align: right">
                            <div class="graph-money-label">$<span id="BTC-USD"></span></div>
                        </div>
                    </div>
                </div>
                <canvas id="btc-chart" height="100"></canvas>
            </div>
        </div>

        <div class="col-lg-12 row">
            <div class="graph-section">
                <div class="trade-graph-top-bar">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="graph-main-label ">Ethereum</div>
                            <div><i class="fa fa-circle" style="color: #9370DB"></i> ETH</div>
                        </div>
                        <div class="col-xs-6" style="text-align: right">
                            <div class="graph-money-label">$<span id="ETH-USD"></span></div>
                        </div>
                    </div>
                </div>
                <canvas id="eth-chart" height="100"></canvas>
            </div>
        </div>

        <div class="col-lg-12 row">
            <div class="graph-section">
                <div class="trade-graph-top-bar">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="graph-main-label ">Litecoin</div>
                            <div><i class="fa fa-circle" style="color: #335F89"></i> LTC</div>
                        </div>
                        <div class="col-xs-6" style="text-align: right">
                            <div class="graph-money-label">$<span id="LTC-USD"></span></div>
                        </div>
                    </div>
                </div>
                <canvas id="ltc-chart" height="100"></canvas>
            </div>
        </div>

    </div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>

    $(document).ready(function() {

        var chart_options = {
            scales: {xAxes: [{ticks: {display: false}}]},
            legend: {display: false}
        };

        d = new Date();
        var end = d.toISOString();

        $.getJSON( "https://api.gdax.com/products/BTC-USD/candles", {granularity: 900}, function( data ) {
        }).done(function(data) {

            var closeData = [];
            var timeData = [];
            for (var j = 95; j >= 0; j--) {
                closeData.push(data[j][4]);
                var date = new Date(data[j][0]*1000);
                var hours = date.getHours();
                var minutes = "0" + date.getMinutes();
                var formattedTime = hours + ':' + minutes.substr(-2);
                timeData.push(formattedTime);
            }

            chartObj = $('#btc-chart');
            var chart = new Chart(chartObj, {
                type: 'line',
                data: {
                    labels: timeData,
                    datasets: [{
                        label: 'BTH-USD - Close',
                        data: closeData,
                        backgroundColor:"#F4A460",
                        pointRadius: 0
                    }]
                },
                options: chart_options
            });

        });

        $.getJSON( "https://api.gdax.com/products/ETH-USD/candles", {granularity: 900}, function( data ) {
        }).done(function(data) {

            var closeData = [];
            var timeData = [];
            for (var j = 95; j >= 0; j--) {
                closeData.push(data[j][4]);
                var date = new Date(data[j][0]*1000);
                var hours = date.getHours();
                var minutes = "0" + date.getMinutes();
                var formattedTime = hours + ':' + minutes.substr(-2);
                timeData.push(formattedTime);
            }

            chartObj = $('#eth-chart');
            chartObj.height = 100;

            var chart = new Chart(chartObj, {
                type: 'line',
                data: {
                    labels: timeData,
                    datasets: [{
                        label: 'ETH-USD',
                        data: closeData,
                        backgroundColor:"#9370DB",
                        pointRadius: 0
                    }]
                },
                options: chart_options
            });
        });

        $.getJSON( "https://api.gdax.com/products/LTC-USD/candles", {granularity: 900}, function( data ) {
        }).done(function(data) {

            var closeData = [];
            var timeData = [];
            for (var j = 95; j >= 0; j--) {
                closeData.push(data[j][4]);
                var date = new Date(data[j][0]*1000);
                var hours = date.getHours();
                var minutes = "0" + date.getMinutes();
                var formattedTime = hours + ':' + minutes.substr(-2);
                timeData.push(formattedTime);
            }

            chartObj = $('#ltc-chart');

            var chart = new Chart(chartObj, {
                type: 'line',
                data: {
                    labels: timeData,
                    datasets: [{
                        label: 'LTC-USD',
                        data: closeData,
                        backgroundColor:"#335F89",
                        pointRadius: 0
                    }]
                },
                options: chart_options
            });
        });

        var btBalance = (<?=$btcBalance?>) ? <?=$btcBalance?> : 0;
        var ethBalance = (<?=$ethBalance?>) ? <?=$ethBalance?> : 0;
        var ltcBalance = (<?=$ltcBalance?>) ? <?=$ltcBalance?> : 0;
        var btcusd = 0;
        var etcusd = 0;
        var ltcusd = 0;

        var socket = new WebSocket("wss://ws-feed.gdax.com");
        socket.onopen = function() {
            var msg = {
                type: "subscribe",
                channels: [{name: 'ticker', "product_ids": ["BTC-USD", 'ETH-USD', 'LTC-USD']}]
            };
            socket.send(JSON.stringify(msg));
        };

        socket.onmessage = function(event) {

            var msg = JSON.parse(event.data);

            if (msg.product_id) {

                var price = parseFloat(msg.price).toFixed(2);
                var value = 0;

                if (msg.product_id == 'BTC-USD') {
                    btcusd = btBalance * msg.price;
                } else if (msg.product_id == 'ETH-USD') {
                    etcusd = ethBalance * msg.price;
                } else if (msg.product_id == 'LTC-USD') {
                    ltcusd = ltcBalance * msg.price;
                }

                var accountBallance = (<?=$balance?>) ? <?=$balance?> : 0;
                accountBallance = accountBallance + btcusd + etcusd + ltcusd;


                $('#' + msg.product_id).text(price);
                $('#current-balance').text(parseFloat(accountBallance).toFixed(2));
            }
        };

    });

</script>


