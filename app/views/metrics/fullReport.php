<?php
$this->load->view('metrics/burnrate', array('expenses' => $expenses, 'collapsed' => true));
$this->load->view('metrics/revenues', array('revenues' => $revenues, 'collapsed' => true));
$this->load->view('metrics/userbase', array('userbase' => $userbase, 'collapsed' => true));
$this->load->view('metrics/web', array('web' => $web, 'collapsed' => true));
$this->load->view('metrics/acquisition', array('acquisition' => $acquisition, 'collapsed' => true));
$this->load->view('metrics/userbaseDefinitions');
$this->load->view('metrics/acquisitionDefinitions');
?>

