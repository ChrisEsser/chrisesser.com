<?php
    switch($this->_action) {
        case 'accounts':
        case 'settings':
            $headerText = ucfirst($this->_action);
            break;
        case 'account':
            $headerText = ucfirst($type) . ' - ' . ucfirst($currency);
            break;
        default:
            $headerText = '';
    }
?>


<div class="small-top-bar">

    <span class="pull-left"><a href="<?=BASE_PATH?>/auth/logout" style="color: white; margin-left: 15px"><i class="fa fa-lock"></i>&nbsp;Logout</a></span>

    <?=$headerText?>

    <span id="order-label"></span>&nbsp;<span id="coin-label"></span>
    <div class="pull-right">
        <a href="<?=BASE_PATH?>" style="color:#fff; margin-right: 15px;"><i class="fa fa-home fa-2x"></i></a>
    </div>

</div>
<div class="top-gap-fix"></div>

<div class="container"><?=HTML::displaySiteErrors()?></div>