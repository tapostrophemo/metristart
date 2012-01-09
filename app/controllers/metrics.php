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
    if (!$this->form_validation->run('metrics_revenue')) {
      $this->_showForm('getRevenue', 'revenue', 'dataentry/revenue', $month, $year);
    }
    else {
      $this->_saveForm('updateRevenues', 'saveRevenues', '_revenueFields', 'Revenues saved.', 'Problem saving revenues.');
    }
  }

  function _revenueFields() {
    return array(
      $this->input->post('segment'),
      $this->input->post('revenue'),
      $this->input->post('varcost'),
      $this->input->post('fixcost'));
  }

  function revenues() {
    $data = array('revenues' => $this->Metric->getRevenueReport($this->userid));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/revenues', $data, true)));
  }

  function modsegment($name, $fromMonth, $fromYear) {
    $fromSegment = "$fromMonth/$fromYear";
    if (!$this->form_validation->run('metrics_modsegment')) {
      $content = $this->load->view('dataentry/modsegment', array('name' => $name, 'segment' => $fromSegment), true);
      $this->load->view('pageTemplate', array('content' => $content));
    }
    else {
      $this->Metric->modifyKey($this->userid, $name, $fromSegment, $this->input->post('segment'));
      $this->redirectWithMessage("Segment for '$name' category updated.", '/dashboard');
    }
  }

  function _is_modifiable_category($name) {
    if (!in_array($name, array('expenses'))) {
      $this->form_validation->set_message('_is_modifiable_category', "The %s '$name' is not modifiable at this time.");
      return false;
    }
    return true;
  }

  function _is_unused_segment($segment) {
    $name = $this->uri->segment(2);
    if ($this->Metric->isKey($this->userid, $name, $segment)) {
      $this->form_validation->set_message('_is_unused_segment', 'Unable to change current month to "%s".');
      return false;
    }
    return true;
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
      $this->_showForm('getUserbase', 'registrations', 'dataentry/userbase', $month, $year);
    }
    else {
      $this->_saveForm('updateUserbase', 'saveUserbase', '_userbaseFields', 'Userbase data saved.', 'Problem saving userbase data.');
    }
  }

  function _userbaseFields() {
    return array(
      $this->input->post('segment'),
      $this->input->post('registrations'),
      $this->input->post('activations'),
      $this->input->post('retentions30'),
      $this->input->post('retentions90'),
      $this->input->post('paying'));
  }

  function ub() {
    $data = array('userbase' => $this->Metric->getUserbaseReport($this->userid));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/userbase', $data, true)));
  }

  function web($month = null, $year = null) {
    if (!$this->form_validation->run('metrics_web')) {
      $this->_showForm('getWeb', 'pageViews', 'dataentry/web', $month, $year);
    }
    else {
      $this->_saveForm('updateWeb', 'saveWeb', '_webFields', 'Web metrics saved.', 'Problem saving web metrics.');
    }
  }

  function _webFields() {
    return array(
      $this->input->post('segment'),
      $this->input->post('uniques'),
      $this->input->post('views'),
      $this->input->post('visits'));
  }

  function wb() {
    $data = array('web' => $this->Metric->getWebMetricsReport($this->userid));
    $this->load->view('pageTemplate', array('content' => $this->load->view('metrics/web', $data, true)));
  }

  function acquisition($month = null, $year = null) {
    if (!$this->form_validation->run('metrics_acquisition')) {
      $this->_showForm('getAcquisitions', 'acqPaidCost', 'dataentry/acquisition', $month, $year);
    }
    else {
      $this->_saveForm('updateAcquisitions', 'saveAcquisitions', '_acquisitionFields', 'Acquisition costs saved.', 'Problems saving acquisition costs.');
    }
  }

  function _acquisitionFields() {
    return array(
      $this->input->post('segment'),
      $this->input->post('acqPaidCost'),
      $this->input->post('acqNetCost'),
      $this->input->post('ads'),
      $this->input->post('viratio'));
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

  function _showForm($dataGetter, $metricKey, $viewName, $month = null, $year = null) {
    $data['editing'] = false;
    if ($month != null && $year != null) {
      $data = $this->Metric->$dataGetter($this->userid, "$month/$year");
      $data['editing'] = true;
    }
    $data['last_entry_date'] = $this->Metric->lastEntryDate($metricKey, $this->userid);
    $this->load->view('pageTemplate', array('content' => $this->load->view($viewName, $data, true)));
  }

  function _saveForm($update, $save, $formFields, $success, $error) {
    $editing = $this->input->post('editing');
    $next = $this->_next($editing);

    $status = $editing
      ? $this->Metric->$update($this->userid, $this->$formFields())
      : $this->Metric->$save($this->userid, $this->$formFields());

    if ($status) {
      $this->redirectWithMessage($success, $next);
    }
    else {
      $this->redirectWithError($error, $next);
    }
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

