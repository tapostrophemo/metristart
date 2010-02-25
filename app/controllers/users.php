<?php

class Users extends MY_Controller
{
  function __construct() {
    parent::__construct();
    $this->load->model('User');
    log_message('debug', 'Users class initialized');
  }

  function dashboard() {
    if (!$this->User->findById($this->session->userdata('userid'))) {
      $this->redirectWithError('Must be logged in.', '/login');
    }

    $this->load->view('pageTemplate', array('content' => $this->load->view('users/dashboard', null, true)));
  }
}

