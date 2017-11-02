<?php

    $exchange = new Coinexchange();
    $products = $exchange->products();

?>

<style>
    body {
        background-color: #FAFAFA;
    }
    .trade-graph-top-bar {
        margin-bottom: 12px;
        border-bottom: 1px solid lightgray;
        padding-bottom: 5px;
    }
    .graph-main-label {
        font-size: 18px;
    }
    .graph-money-label {
        font-size: 17px;
    }
    .graph-section {
        padding: 10px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 2px 0 rgba(0,0,0,0.16), 0 0 0 1px rgba(0,0,0,0.08);
        transition: box-shadow 200ms cubic-bezier(0.4, 0.0, 0.2, 1);
        margin-top: 15px;
    }
    .chart-container {
        margin-top: 95px;
    }

    .trade-charts-top {
        position: absolute;
        height: 170px;
        width: 100%;
        background-color: #17252E;
        top: 0;
        text-align: center;
        color: white;
    }
    .my-money-label {
        font-size: 30px;
        position: relative;
        margin-top: 20px;
    }
    .my-account-link {
        margin-top: 2px;
    }
    .my-account-link a {
        color: white;
        font-size: 15px;
        text-decoration: none;
    }
</style>

    <div class="trade-charts-top">

        <div class="my-money-label">$123.54</div>
        <div class="my-account-link"><a href="<?=BASE_PATH?>/trade/accounts">Your Accounts <i class="fa fa-arrow-right"></i></a></div>

    </div>

    <div class="container chart-container">

        <div class="col-lg-4">
            <div class="graph-section">
                <div class="trade-graph-top-bar">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="graph-main-label ">Bitcoin</div>
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

        <div class="col-lg-4">
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

        <div class="col-lg-4">
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


        var yesterday = new Date(new Date().getTime() - (24 * 60 * 60 * 1000));
        var start = yesterday.toISOString();

        d = new Date();
        var end = d.toISOString();

        $.getJSON( "https://api.gdax.com/products/BTC-USD/candles", {granularity: 900, start: start}, function( data ) {
        }).done(function(data) {

            var closeData = [];
            var timeData = [];
            for (var j = 95; j >= 0; j--) {
                closeData.push(Math.round(data[j][4]));
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
                        label: 'BTH-USD',
                        data: closeData,
                        backgroundColor:"#F4A460",
                        pointRadius: 0
                    }]
                },
                options: chart_options
            });
        });

        $.getJSON( "https://api.gdax.com/products/ETH-USD/candles", {granularity: 900, start: start}, function( data ) {
        }).done(function(data) {

            var closeData = [];
            var timeData = [];
            for (var j = 95; j >= 0; j--) {
                closeData.push(Math.round(data[j][4]));
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

        $.getJSON( "https://api.gdax.com/products/LTC-USD/candles", {granularity: 900, start: start}, function( data ) {
        }).done(function(data) {

            var closeData = [];
            var timeData = [];
            for (var j = 95; j >= 0; j--) {
                closeData.push(Math.round(data[j][4]));
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
            var price = parseFloat(msg.price).toFixed(2);

            if (msg.product_id ) {
                $('#' + msg.product_id).text(price);
            }
        };

    });

    $(document).ready(function() {

    });

</script>


