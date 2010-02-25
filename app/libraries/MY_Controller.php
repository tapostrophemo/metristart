<?php

class MY_Controller extends Controller
{
  function __construct() {
    parent::Controller();
    $this->form_validation->set_error_delimiters('<div class="err rounded">', '</div>');
    log_message('debug', 'MY_Controller class initialized');
  }

  function redirectWithError($errmsg, $path = '') {
    $this->session->set_flashdata('err', $errmsg);
    redirect($path);
  }

  function redirectWithMessage($msg, $path = '') {
    $this->session->set_flashdata('msg', $msg);
    redirect($path);
  }
}

