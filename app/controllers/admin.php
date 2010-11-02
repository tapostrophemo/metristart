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

  function users() {
    $this->load->model('User');
    $data['users'] = $this->User->findAll();
    $this->load->view('pageTemplate', array('content' => $this->load->view('admin/users', $data, true)));
  }

  function userDetail($id) {
    $this->load->model('User');
    $user = $this->User->findById($id);
    $this->load->view('admin/userDetail', array('user' => $user));
  }

  function backup() {
    if (!$this->form_validation->run('admin_backup')) {
      $this->load->view('pageTemplate', array('content' => $this->load->view('admin/backup', null, true)));
    }
    else {
      $this->load->dbutil();
      $backup =& $this->dbutil->backup();
      $this->load->helper('download');
      force_download($this->input->post('prefix').'.sql.gz', $backup);
    }
  }
}

