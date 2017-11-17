<?php

$router->addRoutes([
    ['GET', '', 'IndexController#index'],
]);

$router->addRoutes([
    ['GET', 'trade', 'TradeController#prices'],
    ['GET', 'trade/prices', 'TradeController#prices'],
    ['GET', 'trade/accounts', 'TradeController#accounts'],
    ['GET', 'trade/buy', 'TradeController#buy'],
    ['GET', 'trade/alerts', 'TradeController#alerts'],
    ['GET', 'trade/settings', 'TradeController#settings'],
    ['POST', 'trade/settings/save', 'TradeController#settings_save'],

    ['POST', 'trade/ajax/buy', 'AjaxController#buy'],
    ['POST', 'trade/ajax/sell', 'AjaxController#sell'],

    ['GET', 'login', 'LoginController#login'],
    ['POST', 'auth/login', 'LoginController#auth'],

    ['GET', 'resume', 'ResumeController#resume'],
    ['GET', 'portfolio', 'PortfolioController#portfolio'],

]);
