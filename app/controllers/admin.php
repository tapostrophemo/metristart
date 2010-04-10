<?php

class Admin extends Controller
{
  function __construct() {
    parent::__construct();
    if (!$this->session->userdata('is_admin')) {
      echo 'Unauthorized';
      exit(1);
    }
  }

  function index() {
    $this->load->view('pageTemplate', array('content' => $this->load->view('admin/menu', null, true)));
  }
}

