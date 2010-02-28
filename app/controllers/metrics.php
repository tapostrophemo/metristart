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

  function cash() {
    $userid = $this->session->userdata('userid');

    if (!$this->form_validation->run('metrics_cash')) {
      $data = array('cash' => $this->Metric->getCash($userid));
      if (count($data) == 1) {
        $initialInfusion = $data['cash']->data;
        $data['burn'] = $this->Metric->getBurn($userid);
      }
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/cash.php', $data, true)));
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
}

