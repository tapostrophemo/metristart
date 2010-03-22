<?php

class Pages extends MY_Controller
{
  function index() {
    $this->load->view('pageTemplate', array('content' => $this->load->view('pages/home', null, true)));
  }
}

