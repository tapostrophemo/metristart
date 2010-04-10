<?php

class Site extends MY_Controller
{
  function __construct() {
    parent::__construct();
    $this->load->model('User');
    log_message('debug', 'Site class initialized');
  }

  function register() {
    if (!$this->form_validation->run('site_register')) {
      $this->load->view('pageTemplate', array('content' => $this->load->view('site/register', null, true)));
    }
    else {
      $newUserId = $this->User->register(
        $this->input->post('username'),
        $this->input->post('password'),
        $this->input->post('email'));
      if (null == $newUserId) {
        $this->redirectWithError('Username has already been taken', '/register');
      }

      $this->session->set_userdata('userid', $newUserId);
      $this->session->set_userdata('username', $this->input->post('username'));
      $this->session->set_userdata('logged_in', true);
      $this->redirectWithMessage('Thank you for registering.', '/dashboard');
    }
  }

  function login() {
    if (!$this->form_validation->run('site_login')) {
      $this->load->view('pageTemplate', array('content' => $this->load->view('site/login', null, true)));
    }
    else {
      $user = $this->User->markLogin($this->input->post('username'));
      $this->session->set_userdata('userid', $user->id);
      $this->session->set_userdata('username', $this->input->post('username'));
      $this->session->set_userdata('logged_in', true);
      $this->session->set_userdata('is_admin', $user->is_admin);
      $this->redirectWithMessage('Welcome back.', '/dashboard');
    }
  }

  function _is_registered_user($junk) {
    if (!$this->User->isRegistered($this->input->post('username'), $this->input->post('password'))) {
      $this->form_validation->set_message('_is_registered_user', 'Invalid username or password');
      return false;
    }
    return true;
  }

  function logout() {
    $this->session->sess_destroy();
    redirect('/');
  }
}

