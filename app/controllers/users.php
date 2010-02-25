<?php

class Users extends MY_Controller
{
  function __construct() {
    parent::__construct();
    $this->load->model('User');
    $this->load->model('Metric');
    log_message('debug', 'Users class initialized');
  }

  function dashboard() {
    if (!$this->User->findById($this->session->userdata('userid'))) {
      $this->redirectWithError('Must be logged in.', '/login');
    }

    $data = array('revenues' => $this->Metric->getRevenueReport($this->session->userdata('userid')));

    $this->load->view('pageTemplate', array('content' => $this->load->view('users/dashboard', $data, true)));
  }
}

