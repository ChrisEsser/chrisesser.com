<div class="container">

    <div class="card card-container">

        <div style="text-align: center; margin-bottom: 45px">
            <h3>GDAX API</h3>
        </div>

        <form class="form-signin" name="apiForm" method="POST" action="<?=BASE_PATH?>/trade/settings/save">

            <!-- api_key -->
            <label class="control-label" for="api_key">API Key</label>
            <input class="form-control" type="text" name="api_key" id="api_key" placeholder="Key" value="<?=(!empty($keys['api_key'])) ? $keys['api_key'] : ''?>" />

            <!-- secret -->
            <label class="control-label" for="secret">Secret</label>
            <textarea class="form-control" name="secret" id="secret" placeholder="Secret" rows="4"><?=(!empty($keys['secret'])) ? $keys['secret'] : ''?></textarea>

            <!-- phrase -->
            <label class="control-label" for="phrase">Phrase</label>
            <input class="form-control" type="text" name="phrase" id="phrase" placeholder="Phrase" value="<?=(!empty($keys['phrase'])) ? $keys['phrase'] : ''?>" />

            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" role="button">Save</button>

        </form>

    </div>

</div>
