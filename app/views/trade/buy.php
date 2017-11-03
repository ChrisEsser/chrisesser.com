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




</style>

<div class="small-top-bar">Buy <span id="coin-label">Bitcoin</span></div>
<div class="top-gap-fix"></div>


<div class="container">

    <div class="buy-btn-group" role="group">
        <button class="active" type="button">BTC</button>
        <button type="button">ETH</button>
        <button type="button">LTC</button>
    </div>

    <div class="switch-container">
        <div style="line-height: 40px; vertical-align: middle; font-size: 15px;">Margin Trading</div>
        <div>
            <input type="checkbox" id="switch" class="toggle-switch-input" />
            <label for="switch" class="toggle-switch-label">Toggle</label>
        </div>

    </div>

    <div class="clearfix"></div>

    <div class="buy-balance-container panel">
        <div class="panel-body">
            <h4>BALANCE</h4>
            <div style="margin-top: 7px;" class="row">
                <div class="col-xs-6">USD</div>
                <div class="col-xs-6" style="text-align: right;">0.00</div>
            </div>
            <div style="margin-top: 7px;" class="row">
                <div class="col-xs-6" style="width: 50%; display: inline-block">BTC</div>
                <div class="col-xs-6" style="text-align: right;">0.00684701</div>
            </div>
        </div>
    </div>

</div>



<script>

    $('.buy-btn-group button').click(function() {

        var what = $(this).text();
        $('.buy-btn-group button').removeClass('active');
        $(this).addClass('active');

        if (what == 'BTC') {
            $('#coin-label').text('Bitcoin');
        } else if (what == 'ETH') {
            $('#coin-label').text('Ethereum');
        } else if (what == 'LTC') {
            $('#coin-label').text('Litecoin')
        }

    });

</script>