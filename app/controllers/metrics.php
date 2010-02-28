<?php

class Metrics extends MY_Controller
{
  function __construct() {
    parent::__construct();
    $this->load->model('User');
    $this->load->model('Metric');
    log_message('debug', 'Metrics class initialized');

    if (!$this->User->findById($this->session->userdata('userid'))) {
      $this->redirectWithError('Must be logged in.', '/login');
    }
  }

  function revenue() {
    if (!$this->form_validation->run('metrics_revenue')) {
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/revenue.php', null, true)));
    }
    else {
      $userid = $this->session->userdata('userid');
      $month = $this->input->post('segment');

      $this->Metric->saveRevenue($userid, $month, $this->input->post('revenue'));
      $this->Metric->saveVariableCost($userid, $month, $this->input->post('varcost'));
      if ($this->input->post('fixcost')) {
        $this->Metric->saveFixedCost($userid, $month, $this->input->post('fixcost'));
      }

      $this->redirectWithMessage('Revenues saved.', '/dashboard');
    }
  }

  function revgraph($height) {
    $this->load->library('bargraph');

    $data = $this->Metric->getRevenueReport($this->session->userdata('userid'));
    $revs = array();
    foreach ($data as $r) {
      $revs[] = $r->revenue;
    }
    $this->bargraph->setData($revs);
    $this->bargraph->render((int) $height);
  }

  function revenues() {
    $data = array('revenues' => $this->Metric->getRevenueReport($this->session->userdata('userid')));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/revenues', $data, true)));
  }

  function expense() {
    $userid = $this->session->userdata('userid');

    if (!$this->form_validation->run('metrics_expense')) {
      $data = array('cash' => $this->Metric->getCash($userid));
      if (count($data['cash']) == 1) {
        $data['burn'] = $this->Metric->getBurn($userid);
      }
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/expense.php', $data, true)));
    }
    else {
      $this->Metric->saveExpenses(
        $this->session->userdata('userid'),
        $this->input->post('segment'),
        $this->input->post('expenses'));
      $this->redirectWithMessage('Expenses saved.', '/dashboard');
    }
  }

  function infusion() {
    $userid = $this->session->userdata('userid');

    if (!$this->form_validation->run('metrics_infusion')) {
      $data = array('cash' => $this->Metric->getCash($userid));
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/cash.php', $data, true)));
    }
    else {
      $this->Metric->saveCash($userid, $this->input->post('amount'));
      $this->redirectWithMessage('Initial cash infusion saved.', '/dashboard');
    }
  }

  function burngraph($height) {
    $this->load->library('bargraph');

    $data = $this->Metric->getBurnReport($this->session->userdata('userid'));
    $exps = array();
    foreach ($data as $e) {
      $exps[] = $e->cash;
    }
    $this->bargraph->setData($exps);
    $this->bargraph->render((int) $height);
  }

  function burnrate() {
    $data = array('expenses' => $this->Metric->getBurnReport($this->session->userdata('userid')));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/burnrate', $data, true)));
  }

  function userbase() {
    if (!$this->form_validation->run('metrics_userbase')) {
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/userbase', null, true)));
    }
    else {
      $userid = $this->session->userdata('userid');
      $month = $this->input->post('segment');

      $this->Metric->saveRegistrations($userid, $month, $this->input->post('registrations'));
      $this->Metric->saveActivations($userid, $month, $this->input->post('activations'));
      $this->Metric->saveRetentions30($userid, $month, $this->input->post('retentions30'));
      $this->Metric->saveRetentions90($userid, $month, $this->input->post('retentions90'));
      $this->Metric->savePayingCustomers($userid, $month, $this->input->post('paying'));

      $this->redirectWithMessage('Userbase data saved.', '/dashboard');
    }
  }

  function userbasegraph($height) {
    $this->load->library('bargraph');

    $data = $this->Metric->getUserbaseReport($this->session->userdata('userid'));
    $ub = array();
    foreach ($data as $r) {
      $ub[] = $r->registrations;
    }
/*
    foreach ($data as $a) {
      $ub[] = -1*$a->activations;
    }
    foreach ($data as $r30) {
      $ub[] = $r30->retentions30;
    }
    foreach ($data as $r90) {
      $ub[] = -1*$r90->retentions90;
    }
    foreach ($data as $p) {
      $ub[] = $p->payingCustomers;
    }
*/

    $this->bargraph->setData($ub);
    $this->bargraph->render((int) $height);
  }

  function ub() {
    $data = array('userbase' => $this->Metric->getUserbaseReport($this->session->userdata('userid')));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/userbase', $data, true)));
  }
}

