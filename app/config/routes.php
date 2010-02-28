<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = 'pages';
$route['scaffolding_trigger'] = '';

$route['register'] = 'site/register';
$route['login'] = 'site/login';
$route['logout'] = 'site/logout';

$route['dashboard'] = 'users/dashboard';

$route['revenue'] = 'metrics/revenue';
$route['expense'] = 'metrics/expense';
$route['infusion'] = 'metrics/infusion';
$route['userbase'] = 'metrics/userbase';
$route['web'] = 'metrics/web';
$route['acquisition'] = 'metrics/acquisition';

