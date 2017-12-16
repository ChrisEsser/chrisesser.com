<div class="container">

    <p>account info here</p>

    <?php if ($type == 'other') { ?>
        <form method="POST" action="<?=BASE_PATH?>/trade/account/remove">
            <input type="hidden" name="account" value="<?=$currency?>" />
            <input type="hidden" name="type" value="<?=$type?>" />
            <button type="submit" class="btn btn-danger">Remove Coin</button>
        </form>
    <?php } ?>

</div>
