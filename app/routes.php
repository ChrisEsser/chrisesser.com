<?php

/** @var $router Router */

$router->addRoutes([
    ['GET', '', 'IndexController#index'],
]);

$router->addRoutes([

    ['GET', '/trade', 'TradeController#prices'],
    ['GET', '/trade/prices', 'TradeController#prices'],
    ['GET', '/trade/accounts', 'TradeController#accounts'],
    ['POST', '/trade/accounts/add', 'TradeController#add_account'],
    ['GET', '/trade/accounts/add', 'TradeController#add_accounts'],
    ['GET', '/trade/account/[:type]/[:currency]', 'TradeController#account'],
    ['POST', '/trade/account/remove', 'TradeController#remove_account'],
    ['GET', '/trade/buy', 'TradeController#buy'],
    ['GET', '/trade/alerts', 'TradeController#alerts'],
    ['GET', '/trade/settings', 'TradeController#settings'],
    ['POST', '/trade/settings/save', 'TradeController#settings_save'],
    ['GET', '/trade/get_markets/[:term]', 'TradeController#get_markets'],

    ['POST', '/trade/ajax/buy', 'AjaxController#buy'],
    ['POST', '/trade/ajax/sell', 'AjaxController#sell'],

    ['GET', '/login', 'LoginController#login'],
    ['POST', '/auth/login', 'LoginController#auth'],
    ['GET', '/auth/logout', 'LoginController#logout'],

    ['GET', '/resume', 'ResumeController#resume'],
    ['GET', '/portfolio', 'PortfolioController#portfolio'],

    ['GET', '/admin', 'AdminController#admin'],
    ['GET', '/admin/manage/users', 'AdminController#manage_users'],

    ['GET', '/user/delete/[i:id]', 'UserController#delete'],
    ['POST', '/user/save/[i:id]/', 'UserController#save'],
    ['POST', '/user/save', 'UserController#save'],

    ['GET', '/get', 'AwsdataController#get'],

]);