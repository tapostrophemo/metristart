<?php

class Metrics extends MY_Controller
{
  var $userid;

  function __construct() {
    parent::__construct();
    $this->load->model('User');
    $this->load->model('Metric');
    log_message('debug', 'Metrics class initialized');

    $this->userid = $this->session->userdata('userid');
    if (!$this->User->findById($this->userid)) {
      $this->redirectWithError('Must be logged in.', '/login');
    }
  }

  function revenue($month = null, $year = null) {
    $data['editing'] = $month != null && $year != null;

    if (!$this->form_validation->run('metrics_revenue')) {
      if ($data['editing']) {
        $data = $this->Metric->getRevenue($this->userid, "$month/$year");
        $data['editing'] = true;
      }
      $data['last_entry_date'] = $this->Metric->lastEntryDate('revenue', $this->userid);
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/revenue.php', $data, true)));
    }
    else {
      $editing = $this->input->post('editing');
      $next = $this->_next($editing);

      if ($editing) {
        $status = $this->Metric->updateRevenues($this->userid,
          $this->input->post('segment'),
          $this->input->post('revenue'),
          $this->input->post('varcost'),
          $this->input->post('fixcost'));
      }
      else {
        $status = $this->Metric->saveRevenues($this->userid,
          $this->input->post('segment'),
          $this->input->post('revenue'),
          $this->input->post('varcost'),
          $this->input->post('fixcost'));
      }
      if ($status) {
        $this->redirectWithMessage('Revenues saved.', $next);
      }
      else {
        $this->redirectWithError('Problem saving revenues.', $next);
      }
    }
  }

  function revenues() {
    $data = array('revenues' => $this->Metric->getRevenueReport($this->userid));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/revenues', $data, true)));
  }

  function expense($month = null, $year = null) {
    if (!$this->form_validation->run('metrics_expense')) {
      $data = array('cash' => $this->Metric->getCash($this->userid));
      if (count($data['cash']) == 1) {
        $data['burn'] = $this->Metric->getBurn($this->userid);
      }
      if ($data['editing'] = ($month != null && $year != null)) {
        $data['expenses'] = $this->Metric->getExpense($this->userid, "$month/$year");
      }
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/expense.php', $data, true)));
    }
    else {
      $editing = $this->input->post('editing');
      $next = $this->_next($editing);

      if ($editing) {
        $status = $this->Metric->updateExpense($this->userid,
          $this->input->post('segment'),
          $this->input->post('expenses'),
          $this->input->post('description'));
      }
      else {
        $status = $this->Metric->saveExpense($this->userid,
          $this->input->post('segment'),
          $this->input->post('expenses'),
          $this->input->post('description'));
      }

      if ($status) {
        $this->redirectWithMessage('Expenses saved.', $next);
      }
      else {
        $this->redirectWithError('Problem saving expenses.', $next);
      }
    }
  }

  function infusion() {
    if (!$this->form_validation->run('metrics_infusion')) {
      $data = array('cash' => $this->Metric->getCash($this->userid));
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/expense.php', $data, true)));
    }
    else {
      $status = $this->Metric->saveCash($this->userid, $this->input->post('amount'));
      if ($status) {
        $this->redirectWithMessage('Initial cash infusion saved.', '/dashboard');
      }
      else {
        $this->redirectWithError('Problem saving initial cash infusion.', '/dashboard');
      }
    }
  }

  function burnrate() {
    $data = array('expenses' => $this->Metric->getBurnReport($this->userid));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/burnrate', $data, true)));
  }

  function userbase($month = null, $year = null) {
    $data['editing'] = $month != null && $year != null;
    if (!$this->form_validation->run('metrics_userbase')) {
      if ($data['editing']) {
        $data = $this->Metric->getUserbase($this->userid, "$month/$year");
        $data['editing'] = true;
      }
      $data['last_entry_date'] = $this->Metric->lastEntryDate('registrations', $this->userid);
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/userbase', $data, true)));
    }
    else {
      $editing = $this->input->post('editing');
      $next = $this->_next($editing);

      if ($editing) {
        $status = $this->Metric->updateUserbase($this->userid,
          $this->input->post('segment'),
          $this->input->post('registrations'),
          $this->input->post('activations'),
          $this->input->post('retentions30'),
          $this->input->post('retentions90'),
          $this->input->post('paying'));
      }
      else {
        $status = $this->Metric->saveUserbase($this->userid,
          $this->input->post('segment'),
          $this->input->post('registrations'),
          $this->input->post('activations'),
          $this->input->post('retentions30'),
          $this->input->post('retentions90'),
          $this->input->post('paying'));
      }
      if ($status) {
        $this->redirectWithMessage('Userbase data saved.', $next);
      }
      else {
        $this->redirectWithError('Problem saving userbase data.', $next);
      }
    }
  }

  function ub() {
    $data = array('userbase' => $this->Metric->getUserbaseReport($this->userid));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/userbase', $data, true)));
  }

  function web($month = null, $year = null) {
    if (!$this->form_validation->run('metrics_web')) {
      $data['editing'] = false;
      if ($month != null && $year != null) {
        $data = $this->Metric->getWeb($this->userid, "$month/$year");
        $data['editing'] = true;
      }
      $data['last_entry_date'] = $this->Metric->lastEntryDate('pageViews', $this->userid);
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/web', $data, true)));
    }
    else {
      $editing = $this->input->post('editing');
      $next = $this->_next($editing);

      if ($editing) {
        $status = $this->Metric->updateWeb($this->userid,
          $this->input->post('segment'),
          $this->input->post('uniques'),
          $this->input->post('views'),
          $this->input->post('visits'));
      }
      else {
        $status = $this->Metric->saveWeb($this->userid,
          $this->input->post('segment'),
          $this->input->post('uniques'),
          $this->input->post('views'),
          $this->input->post('visits'));
      }

      if ($status) {
        $this->redirectWithMessage('Web metrics saved.', $next);
      }
      else {
        $this->redirectWithError('Problem saving web metrics.', $next);
      }
    }
  }

  function wb() {
    $data = array('web' => $this->Metric->getWebMetricsReport($this->userid));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/web', $data, true)));
  }

  function acquisition($month = null, $year = null) {
    if (!$this->form_validation->run('metrics_acquisition')) {
      $data['editing'] = false;
      if (!$month == null && !$year == null) {
        $data = $this->Metric->getAcquisitions($this->userid, "$month/$year");
        $data['editing'] = true;
      }
      $data['last_entry_date'] = $this->Metric->lastEntryDate('acqPaidCost', $this->userid);
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/acquisition', $data, true)));
    }
    else {
      $editing = $this->input->post('editing');
      $next = $this->_next($editing);

      if ($editing) {
        $status = $this->Metric->updateAcquisitions($this->userid,
          $this->input->post('segment'),
          $this->input->post('acqPaidCost'),
          $this->input->post('acqNetCost'),
          $this->input->post('ads'),
          $this->input->post('viratio'));
      }
      else {
        $status = $this->Metric->saveAcquisitions($this->userid,
          $this->input->post('segment'),
          $this->input->post('acqPaidCost'),
          $this->input->post('acqNetCost'),
          $this->input->post('ads'),
          $this->input->post('viratio'));
      }

      if ($status) {
        $this->redirectWithMessage('Acquisition costs saved.', $next);
      }
      else {
        $this->redirectWithError('Problems saving acquisition costs.', $next);
      }
    }
  }

  function acq() {
    $data = array('acquisition' => $this->Metric->getAcquisitionCostsReport($this->userid));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/acquisition', $data, true)));
  }

  function all() {
    $data['revenues'] = $this->Metric->getRevenueReport($this->userid);
    $data['expenses'] = $this->Metric->getBurnReport($this->userid);
    $data['userbase'] = $this->Metric->getUserbaseReport($this->userid);
    $data['web'] = $this->Metric->getWebMetricsReport($this->userid);
    $data['acquisition'] = $this->Metric->getAcquisitionCostsReport($this->userid);
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/fullReport', $data, true)));
  }

  function _next($editing = false) {
    $referrer = $this->input->server('HTTP_REFERER');
    if (!$editing) return '/dashboard';
    if (strpos($referrer, '/acquisition/') !== false) return '/metrics/acq';
    if (strpos($referrer, '/expense/')     !== false) return '/metrics/burnrate';
    if (strpos($referrer, '/revenue/')     !== false) return '/metrics/revenues';
    if (strpos($referrer, '/userbase/')    !== false) return '/metrics/ub';
    if (strpos($referrer, '/web/')         !== false) return '/metrics/wb';
    return '/dashboard';
  }
}

