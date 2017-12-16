<div class="container">

    <div>
        <div class="pull-right">
            <a href="<?=BASE_PATH?>/trade/accounts/add"><i class="fa fa-plus"></i>&nbsp;Add Accounts</a>
        </div>
    </div>

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

            <li class="list-group-item accounts-row" data-type="gdax" data-currency="<?=$account['currency']?>">
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
                        <?=($account['currency'] == 'USD') ? '$' . number_format($account['balance'], 2) :$account['balance']?><br />
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

            <li class="list-group-item accounts-row" data-type="coinbase" data-currency="<?=$account['currency']?>">
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
                        <?=($account['currency'] == 'USD') ? '$' . number_format($account['balance'], 2) :$account['balance']?><br />
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

    <?php if (!empty($otherAccounts)) { ?>

        <h4 class="account-type-header">Other Accounts</h4>

        <?php if (!count($otherAccounts)) { ?>

            <div class="well">No other accounts have been added yet. Add an account <a href="<?=BASE_PATH?>/trade/accounts/add">here</a>.</div>

        <?php } else { ?>

            <ul class="list-group">
                <?php foreach($otherAccounts as $account) { ?>

                    <?php if ($account->market_name == 'BTC') {
                        $colorClass = 'btc-color';
                        $icon = 'bitcoin';
                        $dollarValue = $btcUsd;
                    } else if ($account->market_name == 'ETH') {
                        $colorClass = 'eth-color';
                        $icon = 'bitcoin';
                        $dollarValue = $ethUsd;
                    } else if ($account->market_name == 'LTC') {
                        $colorClass = 'ltc-color';
                        $icon = 'bitcoin';
                        $dollarValue = $ltcUsd;
                    } else if ($account->market_name == 'USD') {
                        $colorClass = 'usd-color';
                        $icon = 'usd';
                    } else if ($account->market_name == 'XLM') {
                        $colorClass = 'usd-color';
                        $icon = 'usd';

                    } ?>

                    <li class="list-group-item accounts-row" data-type="other" data-currency="<?=$account->market_name?>">
                        <div class="accounts-left">
                            <div class="figure-container">
                                <figure class="circle <?=$colorClass?>"><i class="fa fa-<?=$icon?>"></i></figure>
                            </div>
                            <div class="account-label">
                                <?=$account->market_name?>
                            </div>
                        </div>
                        <div class="accounts-right">
                            <div>
                                <?=($account->market_name == 'USD') ? '$' . number_format($account->balance, 2) : $account->balance?><br />
                                <?php if ($account->market_name != 'USD') { ?>
                                    $<?=number_format($account->balance * $dollarValue, 2)?>
                                <?php } ?>
                            </div>
                            <div class="chevron-container">
                                <i class="fa fa-chevron-right"></i>
                            </div>

                        </div>
                    </li>
                <?php } ?>
            </ul>

        <?php } ?>



    <?php } ?>

</div>

<script>
    $(document).ready(function() {

        $('li').click(function() {
            var type = $(this).data('type');
            var currency = $(this).data('currency');
            window.location.href = '<?=BASE_PATH?>/trade/account/' + type + '/' + currency;
        });

    });
</script>