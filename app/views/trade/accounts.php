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
                        <?=($account['currency'] == 'USD') ? '$' : ''?><?=number_format($account['balance'])?><br />
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
                        <?=($account['currency'] == 'USD') ? '$' : ''?><?=number_format($account['balance'])?><br />
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