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
  )
);

