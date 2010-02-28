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
      ORDER BY r.segment";
    return $this->db->query($sql, $userid)->result();
  }

  function getCash($userid) {
    $sql = "SELECT * FROM metrics WHERE user_id = ? AND name = 'cash'";
    return $this->db->query($sql, $userid)->row(0);
  }

  function getBurn($userid) {
    $sql = "
      SELECT Sum(data) AS burn, Max(segment) AS month
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
      ORDER BY month";
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
}

