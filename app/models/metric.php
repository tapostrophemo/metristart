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
}

