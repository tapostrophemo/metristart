<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = 'pages';
$route['scaffolding_trigger'] = '';

$route['register'] = 'site/register';
$route['login'] = 'site/login';
$route['logout'] = 'site/logout';

$route['dashboard'] = 'users/dashboard';
$route['account'] = 'users/account';

$route['revenue'] = 'metrics/revenue';
$route['revenue/(:num)/(:num)'] = 'metrics/revenue/$1/$2';
$route['expense'] = 'metrics/expense';
$route['expense/(:num)/(:num)'] = 'metrics/expense/$1/$2';
$route['infusion'] = 'metrics/infusion';
$route['userbase'] = 'metrics/userbase';
$route['userbase/(:num)/(:num)'] = 'metrics/userbase/$1/$2';
$route['web'] = 'metrics/web';
$route['web/(:num)/(:num)'] = 'metrics/web/$1/$2';
$route['acquisition'] = 'metrics/acquisition';

