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

  function revenue($month = null, $year = null) {
    $userid = $this->session->userdata('userid');
    $data['editing'] = $month != null && $year != null;

    if (!$this->form_validation->run('metrics_revenue')) {
      if ($data['editing']) {
        $data = $this->Metric->getRevenue($userid, "$month/$year");
        $data['editing'] = true;
      }
      $data['last_entry_date'] = $this->Metric->lastEntryDate('revenue', $userid);
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/revenue.php', $data, true)));
    }
    else {
      if ($this->input->post('editing')) {
        $status = $this->Metric->updateRevenues($userid,
          $this->input->post('segment'),
          $this->input->post('revenue'),
          $this->input->post('varcost'),
          $this->input->post('fixcost'));
      }
      else {
        $status = $this->Metric->saveRevenues($userid,
          $this->input->post('segment'),
          $this->input->post('revenue'),
          $this->input->post('varcost'),
          $this->input->post('fixcost'));
      }
      if ($status) {
        $this->redirectWithMessage('Revenues saved.', '/dashboard');
      }
      else {
        $this->redirectWithError('Problem saving revenues.', '/dashboard');
      }
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

  function expense($month = null, $year = null) {
    $userid = $this->session->userdata('userid');

    if (!$this->form_validation->run('metrics_expense')) {
      $data = array('cash' => $this->Metric->getCash($userid));
      if (count($data['cash']) == 1) {
        $data['burn'] = $this->Metric->getBurn($userid);
      }
      if ($data['editing'] = ($month != null && $year != null)) {
        $data['expenses'] = $this->Metric->getExpense($userid, "$month/$year");
      }
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/expense.php', $data, true)));
    }
    else {
      if ($this->input->post('editing')) {
        $status = $this->Metric->updateExpense($userid,
          $this->input->post('segment'),
          $this->input->post('expenses'),
          $this->input->post('description'));
      }
      else {
        $status = $this->Metric->saveExpense($userid,
          $this->input->post('segment'),
          $this->input->post('expenses'),
          $this->input->post('description'));
      }

      if ($status) {
        $this->redirectWithMessage('Expenses saved.', '/dashboard');
      }
      else {
        $this->redirectWithError('Problem saving expenses.', '/dashboard');
      }
    }
  }

  function infusion() {
    $userid = $this->session->userdata('userid');

    if (!$this->form_validation->run('metrics_infusion')) {
      $data = array('cash' => $this->Metric->getCash($userid));
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/expense.php', $data, true)));
    }
    else {
      $status = $this->Metric->saveCash($userid, $this->input->post('amount'));
      if ($status) {
        $this->redirectWithMessage('Initial cash infusion saved.', '/dashboard');
      }
      else {
        $this->redirectWithError('Problem saving initial cash infusion.', '/dashboard');
      }
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

  function userbase($month = null, $year = null) {
    $userid = $this->session->userdata('userid');
    $data['editing'] = $month != null && $year != null;
    if (!$this->form_validation->run('metrics_userbase')) {
      if ($data['editing']) {
        $data = $this->Metric->getUserbase($userid, "$month/$year");
        $data['editing'] = true;
      }
      $data['last_entry_date'] = $this->Metric->lastEntryDate('registrations', $userid);
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/userbase', $data, true)));
    }
    else {
      $userid = $this->session->userdata('userid');
      $month = $this->input->post('segment');

      if ($this->input->post('editing')) {
        $status = $this->Metric->updateUserbase($this->session->userdata('userid'),
          $this->input->post('segment'),
          $this->input->post('registrations'),
          $this->input->post('activations'),
          $this->input->post('retentions30'),
          $this->input->post('retentions90'),
          $this->input->post('paying'));
      }
      else {
        $status = $this->Metric->saveUserbase($this->session->userdata('userid'),
          $this->input->post('segment'),
          $this->input->post('registrations'),
          $this->input->post('activations'),
          $this->input->post('retentions30'),
          $this->input->post('retentions90'),
          $this->input->post('paying'));
      }
      if ($status) {
        $this->redirectWithMessage('Userbase data saved.', '/dashboard');
      }
      else {
        $this->redirectWithError('Problem saving userbase data.', '/dashboard');
      }
    }
  }

  function userbasegraph($height) {
    $this->load->library('bargraph');

    $data = $this->Metric->getUserbaseReport($this->session->userdata('userid'));
    $ub = array();
    foreach ($data as $r) {
      $ub[] = $r->registrations;
    }
/* TODO: determine which metric (or combination thereof) best represents userbase data
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

  function web($month = null, $year = null) {
    $userid = $this->session->userdata('userid');

    if (!$this->form_validation->run('metrics_web')) {
      $data['editing'] = false;
      if ($month != null && $year != null) {
        $data = $this->Metric->getWeb($userid, "$month/$year");
        $data['editing'] = true;
      }
      $data['last_entry_date'] = $this->Metric->lastEntryDate('pageViews', $userid);
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/web', $data, true)));
    }
    else {
      if ($this->input->post('editing')) {
        $status = $this->Metric->updateWeb($userid,
          $this->input->post('segment'),
          $this->input->post('uniques'),
          $this->input->post('views'),
          $this->input->post('visits'));
      }
      else {
        $status = $this->Metric->saveWeb($userid,
          $this->input->post('segment'),
          $this->input->post('uniques'),
          $this->input->post('views'),
          $this->input->post('visits'));
      }

      if ($status) {
        $this->redirectWithMessage('Web metrics saved.', '/dashboard');
      }
      else {
        $this->redirectWithError('Problem saving web metrics.', '/dashboard');
      }
    }
  }

  function webgraph($height) {
    $this->load->library('bargraph');

    $data = $this->Metric->getWebMetricsReport($this->session->userdata('userid'));
    $wm = array();
    foreach ($data as $w) {
      $wm[] = $w->pageViews; // TODO: similar to userbase, which metric is best for dashboard? uniques? visits?
    }

    $this->bargraph->setData($wm);
    $this->bargraph->render((int) $height);
  }

  function wb() {
    $data = array('web' => $this->Metric->getWebMetricsReport($this->session->userdata('userid')));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/web', $data, true)));
  }

  function acquisition($month = null, $year = null) {
    $userid = $this->session->userdata('userid');

    if (!$this->form_validation->run('metrics_acquisition')) {
      $data['editing'] = false;
      if (!$month == null && !$year == null) {
        $data = $this->Metric->getAcquisitions($userid, "$month/$year");
        $data['editing'] = true;
      }
      $data['last_entry_date'] = $this->Metric->lastEntryDate('acqPaidCost', $userid);
      $this->load->view('pageTemplate', array('content' => $this->load->view('dataentry/acquisition', $data, true)));
    }
    else {
      if ($this->input->post('editing')) {
        $status = $this->Metric->updateAcquisitions($userid,
          $this->input->post('segment'),
          $this->input->post('acqPaidCost'),
          $this->input->post('acqNetCost'),
          $this->input->post('ads'),
          $this->input->post('viratio'));
      }
      else {
        $status = $this->Metric->saveAcquisitions($userid,
          $this->input->post('segment'),
          $this->input->post('acqPaidCost'),
          $this->input->post('acqNetCost'),
          $this->input->post('ads'),
          $this->input->post('viratio'));
      }

      if ($status) {
        $this->redirectWithMessage('Acquisition costs saved.', '/dashboard');
      }
      else {
        $this->redirectWithError('Problems saving acquisition costs.', '/dashboard');
      }
    }
  }

  function acqgraph($height) {
    $this->load->library('bargraph');

    $data = $this->Metric->getAcquisitionCostsReport($this->session->userdata('userid'));
    $metrics = array();
    foreach ($data as $m) {
      $metrics[] = $m->netCost; // TODO: similar to userbase, which metric is best for dashboard?
    }

    $this->bargraph->setData($metrics);
    $this->bargraph->render((int) $height);
  }

  function acq() {
    $data = array('acquisition' => $this->Metric->getAcquisitionCostsReport($this->session->userdata('userid')));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/acquisition', $data, true)));
  }

  function all() {
    $userid = $this->session->userdata('userid');
    $data['revenues'] = $this->Metric->getRevenueReport($userid);
    $data['expenses'] = $this->Metric->getBurnReport($userid);
    $data['userbase'] = $this->Metric->getUserbaseReport($userid);
    $data['web'] = $this->Metric->getWebMetricsReport($userid);
    $data['acquisition'] = $this->Metric->getAcquisitionCostsReport($userid);
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/fullReport', $data, true)));
  }
}

