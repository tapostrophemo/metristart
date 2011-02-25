<?php

class Images extends MY_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('User');
    $this->load->model('Metric');
    $this->load->library('bargraph');
    log_message('debug', 'Images class initialized');

    if (!$this->User->findById($this->session->userdata('userid'))) {
      $this->bargraph->setData(array(1, 1, 2, 3, 5, 8, 13, 21));
      $this->bargraph->render(42);
      exit(1);
    }
  }

  function revgraph($height) {
    $data = $this->Metric->getRevenueReport($this->session->userdata('userid'));
    $revs = array();
    foreach ($data as $r) {
      $revs[] = $r->revenue;
    }
    $this->bargraph->setData($revs);
    $this->bargraph->render((int) $height);
  }

  function burngraph($height) {
    $data = $this->Metric->getBurnReport($this->session->userdata('userid'));
    $exps = array();
    foreach ($data as $e) {
      $exps[] = $e->cash;
    }
    $this->bargraph->setData($exps);
    $this->bargraph->render((int) $height);
  }

  function userbasegraph($height) {
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

  function webgraph($height) {
    $data = $this->Metric->getWebMetricsReport($this->session->userdata('userid'));
    $wm = array();
    foreach ($data as $w) {
      $wm[] = $w->pageViews; // TODO: similar to userbase, which metric is best for dashboard? uniques? visits?
    }
    $this->bargraph->setData($wm);
    $this->bargraph->render((int) $height);
  }

  function acqgraph($height) {
    $data = $this->Metric->getAcquisitionCostsReport($this->session->userdata('userid'));
    $metrics = array();
    foreach ($data as $m) {
      $metrics[] = $m->netCost; // TODO: similar to userbase, which metric is best for dashboard?
    }
    $this->bargraph->setData($metrics);
    $this->bargraph->render((int) $height);
  }
}

