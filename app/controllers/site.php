<?php

class Site extends Controller
{
  function index() {
    $this->load->view('pageTemplate', array('content' =>
      $this->load->view('wireframes/dashboard', null, true) .
      $this->load->view('wireframes/dataentry', null, true)));
  }
}

