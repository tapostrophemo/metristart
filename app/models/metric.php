<?php

class Metric extends Model
{
  function saveRevenue($userid, $month, $amount) {
    $data = array('user_id' => $userid, 'name' => 'revenue', 'segment' => $month, 'data' => $amount);
    $this->db->insert('metrics', $data);
  }

  function saveVariableCost($userid, $month, $amount) {
    $data = array('user_id' => $userid, 'name' => 'varcost', 'segment' => $month, 'data' => $amount);
    $this->db->insert('metrics', $data);
  }

  function saveFixedCost($userid, $month, $amount) {
    $data = array('user_id' => $userid, 'name' => 'fixcost', 'segment' => $month, 'data' => $amount);
    $this->db->insert('metrics', $data);
  }

  function getRevenueReport($userid) {
    $sql = "
      SELECT r.segment AS month, r.data AS revenue,
             r.data - vc.data AS contribution_margin,
             r.data - vc.data - Coalesce(fc.data, 0) AS net_operating_income
      FROM metrics r
        JOIN metrics vc ON vc.user_id = r.user_id AND vc.segment = r.segment AND vc.name = 'varcost'
        LEFT JOIN metrics fc ON fc.user_id = r.user_id AND fc.segment = r.segment AND fc.name = 'fixcost'
      WHERE r.user_id = ?
      AND r.name = 'revenue'
      ORDER BY Str_To_Date(r.segment, '%m/%Y')";
    return $this->db->query($sql, $userid)->result();
  }

  function getCash($userid) {
    $sql = "SELECT * FROM metrics WHERE user_id = ? AND name = 'cash'";
    return $this->db->query($sql, $userid)->row(0);
  }

  function getBurn($userid) {
    $sql = "
      SELECT Sum(data) AS burn, Max(Str_To_Date(segment, '%m/%Y')) AS month
      FROM metrics
      WHERE user_id = ?
      AND name = 'expenses'";
    return $this->db->query($sql, $userid)->row(0);
  }

  function saveCash($userid, $amount) {
    $data = array('user_id' => $userid, 'name' => 'cash', 'data' => $amount);
    $this->db->insert('metrics', $data);
  }

  function saveExpenses($userid, $month, $amount) {
    $data = array('user_id' => $userid, 'name' => 'expenses', 'segment' => $month, 'data' => $amount);
    $this->db->insert('metrics', $data);
  }

  function getBurnReport($userid) {
    $sql = "
      SELECT null AS month, 0 AS expenses, data AS cash FROM metrics WHERE user_id = ? AND name = 'cash'
      UNION ALL
      SELECT segment AS month, data AS expenses, 0 AS cash FROM metrics WHERE user_id = ? AND name = 'expenses'
      ORDER BY Str_To_Date(month, '%m/%Y')";
    $results = $this->db->query($sql, array($userid, $userid))->result();

    if (count($results) > 0) {
      $remaining = $results[0]->cash;
      foreach ($results as $r) {
        $remaining -= $r->expenses;
        $r->cash = $remaining;
      }
    }

    return $results;
  }

  function saveRegistrations($userid, $month, $number) {
    $data = array('user_id' => $userid, 'name' => 'registrations', 'segment' => $month, 'data' => $number);
    $this->db->insert('metrics', $data);
  }

  function saveActivations($userid, $month, $number) {
    $data = array('user_id' => $userid, 'name' => 'activations', 'segment' => $month, 'data' => $number);
    $this->db->insert('metrics', $data);
  }

  function saveRetentions30($userid, $month, $number) {
    $data = array('user_id' => $userid, 'name' => 'retentions30', 'segment' => $month, 'data' => $number);
    $this->db->insert('metrics', $data);
  }

  function saveRetentions90($userid, $month, $number) {
    $data = array('user_id' => $userid, 'name' => 'retentions90', 'segment' => $month, 'data' => $number);
    $this->db->insert('metrics', $data);
  }

  function savePayingCustomers($userid, $month, $number) {
    $data = array('user_id' => $userid, 'name' => 'payingCustomers', 'segment' => $month, 'data' => $number);
    $this->db->insert('metrics', $data);
  }

  function getUserbaseReport($userid) {
    $sql = "
      SELECT r.segment AS month, r.data AS registrations, a.data AS activations, r30.data AS retentions30,
             r90.data AS retentions90, p.data AS payingCustomers
      FROM metrics r
        JOIN metrics a ON a.segment = r.segment AND a.name = 'activations'
        JOIN metrics r30 ON r30.segment = r.segment AND r30.name = 'retentions30'
        JOIN metrics r90 ON r90.segment = r.segment AND r90.name = 'retentions90'
        JOIN metrics p ON p.segment = r.segment AND p.name = 'payingCustomers'
      WHERE r.user_id = ?
      AND r.name = 'registrations'
      ORDER BY Str_To_Date(r.segment, '%m/%Y')";
    return $this->db->query($sql, $userid)->result();
  }

  function saveUniques($userid, $month, $number) {
    $data = array('user_id' => $userid, 'name' => 'uniques', 'segment' => $month, 'data' => $number);
    $this->db->insert('metrics', $data);
  }

  function savePageViews($userid, $month, $number) {
    $data = array('user_id' => $userid, 'name' => 'pageViews', 'segment' => $month, 'data' => $number);
    $this->db->insert('metrics', $data);
  }

  function saveVisits($userid, $month, $number) {
    $data = array('user_id' => $userid, 'name' => 'visits', 'segment' => $month, 'data' => $number);
    $this->db->insert('metrics', $data);
  }

  function getWebMetricsReport($userid) {
    $sql = "
      SELECT u.segment AS month, u.data AS uniques, p.data AS pageViews, v.data AS visits
      FROM metrics u
        JOIN metrics p ON p.segment = u.segment AND p.name = 'pageViews'
        JOIN metrics v ON v.segment = u.segment AND v.name = 'visits'
      WHERE u.user_id = ?
      AND u.name = 'uniques'
      ORDER BY Str_To_Date(u.segment, '%m/%Y')";
    return $this->db->query($sql, $userid)->result();
  }

  function saveAcquisitionPaidCost($userid, $month, $number) {
    $data = array('user_id' => $userid, 'name' => 'acqPaidCost', 'segment' => $month, 'data' => $number);
    $this->db->insert('metrics', $data);
  }

  function saveAcquisitionNetCost($userid, $month, $number) {
    $data = array('user_id' => $userid, 'name' => 'acqNetCost', 'segment' => $month, 'data' => $number);
    $this->db->insert('metrics', $data);
  }

  function saveAdExpenses($userid, $month, $number) {
    $data = array('user_id' => $userid, 'name' => 'ads', 'segment' => $month, 'data' => $number);
    $this->db->insert('metrics', $data);
  }

  function saveViralRatio($userid, $month, $number) {
    $data = array('user_id' => $userid, 'name' => 'viratio', 'segment' => $month, 'data' => $number);
    $this->db->insert('metrics', $data);
  }

  function getAcquisitionCostsReport($userid) {
    $sql = "
      SELECT p.segment AS month, p.data AS paidCost, n.data AS netCost, a.data AS ads, v.data AS viratio
      FROM metrics p
        JOIN metrics n ON n.segment = p.segment AND n.name = 'acqNetCost'
        JOIN metrics a ON a.segment = p.segment AND a.name = 'ads'
        JOIN metrics v ON v.segment = p.segment AND v.name = 'viratio'
      WHERE p.user_id = ?
      AND p.name = 'acqPaidCost'
      ORDER BY Str_To_Date(p.segment, '%m/%Y')";
    return $this->db->query($sql, $userid)->result();
  }
}

