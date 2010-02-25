<?php

class Pages extends MY_Controller
{
  function index() {
    $this->load->view('pageTemplate', array('content' => $this->load->view('pages/home', null, true)));
  }

  function wireframes() {
    $this->load->view('pageTemplate', array('content' =>
      $this->load->view('wireframes/dashboard', null, true) .
      $this->load->view('wireframes/dataentry', null, true)));
  }
}

