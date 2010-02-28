<?php

$config = array(
  'site_register' => array(
    array('field' => 'username', 'label' => 'username', 'rules' => 'trim|required|max_length[255]|xss_clean'),
    array('field' => 'password', 'label' => 'password', 'rules' => 'trim|required'),
    array('field' => 'email', 'label' => 'email', 'rules' => 'trim|required|max_length[255]|valid_email|xss_clean')
  ),

  'site_login' => array(
    array('field' => 'username', 'label' => 'username', 'rules' => 'trim|required|max_length[255]|xss_clean'),
    array('field' => 'password', 'label' => 'password', 'rules' => 'trim|required'),
    array('field' => 'user', 'label' => 'user', 'rules' => 'callback__is_registered_user')
  ),

  'metrics_revenue' => array(
    array('field' => 'segment', 'label' => 'month', 'rules' => 'trim|required|mm_yyyy'),
    array('field' => 'revenue', 'label' => 'total revenue', 'rules' => 'trim|required|integer'),
    array('field' => 'varcost', 'label' => 'total variable costs', 'rules' => 'trim|required|integer'),
    array('field' => 'fixcost', 'label' => 'total fixed costs', 'rules' => 'trim|integer')
  ),

  'metrics_expense' => array(
    array('field' => 'segment', 'label' => 'month', 'rules' => 'trim|required|mm_yyyy'),
    array('field' => 'expenses', 'label' => 'total expenses', 'rules' => 'trim|required|integer')
  ),

  'metrics_infusion' => array(
    array('field' => 'amount', 'label' => 'amount', 'rules' => 'trim|required|integer')
  ),

  'metrics_userbase' => array(
    array('field' => 'segment', 'label' => 'month', 'rules' => 'trim|required|mm_yyyy'),
    array('field' => 'registrations', 'label' => 'registrations', 'rules' => 'trim|required|integer'),
    array('field' => 'activations', 'label' => 'activations', 'rules' => 'trim|required|integer'),
    array('field' => 'retentions30', 'label' => '30-day retentions', 'rules' => 'trim|required|integer'),
    array('field' => 'retentions90', 'label' => '90-day retentions', 'rules' => 'trim|required|integer'),
    array('field' => 'paying', 'label' => 'paying customers', 'rules' => 'trim|required|integer')
  ),

  'metrics_web' => array(
    array('field' => 'segment', 'label' => 'month', 'rules' => 'trim|required|mm_yyyy'),
    array('field' => 'uniques', 'label' => 'uniques', 'rules' => 'trim|required|integer'),
    array('field' => 'views', 'label' => 'page views', 'rules' => 'trim|required|integer'),
    array('field' => 'visits', 'label' => 'total visits', 'rules' => 'trim|required|integer')
  )
);

