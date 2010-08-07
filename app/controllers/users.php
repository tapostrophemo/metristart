<?php

class Users extends MY_Controller
{
  function __construct() {
    parent::__construct();
    $this->load->model('User');
    $this->load->model('Metric');
    log_message('debug', 'Users class initialized');

    if (!$this->User->findById($this->session->userdata('userid'))) {
      $this->redirectWithError('Must be logged in.', '/login');
    }
  }

  function dashboard() {
    $this->load->view('pageTemplate', array('content' => $this->load->view('users/dashboard', null, true)));
  }

  function account() {
    if (!$this->form_validation->run('users_account')) {
      $data = array('account' => $this->User->findById($this->session->userdata('userid')));
      $this->load->view('pageTemplate', array('content' => $this->load->view('users/account', $data, true)));
    }
    else {
      $this->User->update(
        $this->session->userdata('userid'),
        $this->input->post('email'),
        $this->input->post('password'));
      $this->redirectWithMessage('Account updated.', '/dashboard');
    }
  }
}

