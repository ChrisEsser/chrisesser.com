<style>
    .showcase {
        position: relative;
        margin-bottom: 1em;
    }

    .showcase.showcase-bordered {
        border: 1px solid #bbb;
    }

    .showcase.showcase-rounded {
        border-radius: 5px;
    }

    .showcase a {
        border-radius: inherit;
    }

    .showcase:hover .overlay-hover {
        /*display: block !important;*/
        opacity: 1.0 !important;
    }

    .showcase:hover .overlay-hide {
        opacity: 0;
        transition: all 3000ms linear;
    }

    .showcase .image {
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
        border-radius: inherit;
        width: 100%;
        padding-bottom: 100%;
        /*little hack*/
    }

    .showcase .image.image-top {
        background-position: center top;
    }

    .showcase .image.image-bottom {
        background-position: center bottom;
    }

    .showcase .image.image-portrait {
        padding-bottom: 150%;
    }

    .showcase .image.image-landscape {
        padding-bottom: 75%;
    }

    .showcase .overlay {
        background-color: rgba(0, 0, 0, 0.6);
        border-radius: inherit;
        cursor: pointer;
        /*opacity: 0.8;*/
        position: absolute;
        z-index: 2;
    }

    .showcase .overlay.overlay-gradient {
        background-color: transparent;
        background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%);
    }

    .showcase .overlay .content {
        color: #fff;
        font-family: "MyriadProCondensed";
        opacity: 1.0 !important;
        padding: 3px 6px;
    }

    .showcase .overlay .content a {
        color: #CCC;
    }

    .showcase .overlay .content a:hover {
        color: #CCC;
    }

    .showcase .overlay.overlay-full {
        height: 100%;
        left: 0;
        text-align: center;
        top: 0;
        width: 100%;
    }

    .showcase .overlay.overlay-full .content {
        font-size: 2em;
        line-height: 100%;
        position: relative;
        top: 50%;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        white-space: pre-wrap;
    }

    .showcase .overlay.overlay-header {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        left: 0;
        top: 0;
        width: 100%;
    }

    .showcase .overlay.overlay-footer {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        left: 0;
        bottom: 0;
        width: 100%;
    }

    .showcase .overlay.overlay-topleft {
        border-bottom-left-radius: 0;
        border-top-right-radius: 0;
        left: 0;
        top: 0;
    }

    .showcase .overlay.overlay-topright {
        border-bottom-right-radius: 0;
        border-top-left-radius: 0;
        right: 0;
        top: 0;
    }

    .showcase .overlay.overlay-zoom {
        color: #EEE;
        height: 24px;
        width: 24px;
        border-radius: 12px;
        top: 5px;
        right: 5px;
        text-align: center;
        line-height: 24px;
        vertical-align: middle;
    }

    .showcase .overlay.overlay-zoom:before {
        font-family: FontAwesome;
        content: "\f0b2";
    }

    .showcase .overlay.overlay-zoom:hover {
        box-shadow: 0 0 1px 1px #C0C0C0;
    }

    .showcase .overlay.overlay-remove {
        background-color: #EEE;
        border-radius: 10px;
        height: 20px;
        right: 8px;
        text-align: center;
        top: 8px;
        width: 20px;
    }

    .showcase .overlay.overlay-remove:before {
        font-family: FontAwesome;
        content: "\f00d";
    }

    .showcase .overlay.overlay-remove:hover {
        background-color: #DDDDDD;
        box-shadow: 0 0 1px 1px #C0C0C0;
    }

    .showcase .overlay.overlay-hover {
        /*display: none;*/
        opacity: 0;
        transition: all 300ms linear;
    }

    .showcase .overlay.overlay-hide {
        transition: all 300ms linear;
    }
</style>

<div class="container">

    <h4 class="account-type-header">Available Currencies</h4>

    <div id="currencies-container">

        <?php foreach ($markets as $market) { ?>

            <div class="col-sm-2 add-currency-box" data-currency="<?=$market->MarketCurrency?>" data-name="<?=$market->MarketCurrencyLong?>">

                <div class="showcase showcase-rounded">

                    <div class="image" style="background-size: cover; background: url('<?=$market->LogoUrl?>'); background-repeat: no-repeat; background-position: 50% 50%;"></div>

                    <div class="overlay overlay-footer">
                        <div class="content" style="font-size: 1em;">
                            <?=$market->MarketCurrencyLong?>&nbsp;(<?=$market->MarketCurrency?>)
                        </div>
                    </div>

                    <div class="overlay overlay-full overlay-hover">
                        <div class="content" style="color: #F47321; text-decoration: underline; ">Add</div>
                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</div>

<!-- add balance -->
<div id="balanceModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Currency</h4>
            </div>
            <div class="modal-body">
                <form class="form-signin" action="" method="GET">
                    <label for="balance">Balance</label>
                    <input type="text" id="balance" name="balance" class="form-control" placeholder="0.0000000">
                    <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" role="button">Add Currency</button>
                </form>

            </div>
        </div>

    </div>
</div>




<script>
    var currency = '';
    $('.add-currency-box').click(function() {

        currency = $(this).data('currency');
        var name = $(this).data('name');

        // pop balance modal
        $('#balanceModal .modal-title').text('Add ' + name + ' (' + currency + ')');
        $('#balanceModal').modal('show');



    });

    $('form').submit(function(e) {

        e.preventDefault();

        var data = {
            currency: currency,
            balance: $('#balance').val()
        };

        $.post('<?=BASE_PATH?>/trade/accounts/add', data, function() {
        }).done(function(result) {

            console.log(result);

            if (result.result && result.result == 'success') {
                location.reload();
            }

        }).fail(function(result) {
            console.log(result);
        });

    });

</script>