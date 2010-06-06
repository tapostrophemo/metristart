<?php

class Metric extends Model
{
  function save($metric, $userid, $month, $number, $description = null) {
    $data = array('name' => $metric, 'user_id' => $userid, 'segment' => $month, 'data' => $number);
    if (null != $description) {
      $data['description'] = $description;
    }
    return $this->db->insert('metrics', $data);
  }

  function update($metric, $userid, $month, $number, $description = null) {
    $criteria = array('name' => $metric, 'user_id' => $userid, 'segment' => $month);
    $data = array('data' => $number);
    if (null != $description) {
      $data['description'] = $description;
    }
    return $this->db->where($criteria)->update('metrics', $data);
  }

  function lastEntryDate($metric, $userid) {
    $sql = "
      SELECT segment AS last_entry_date
      FROM metrics
      WHERE user_id = ?
      AND name = ?
      ORDER BY Str_To_Date(segment, '%m/%Y') DESC
      LIMIT 1";
    $query = $this->db->query($sql, array($userid, $metric));
    return $query->num_rows() > 0 ? $query->row()->last_entry_date : null;
  }

  function saveRevenues($userid, $month, $revenue, $variableCost, $fixedCost) {
    $this->db->trans_start();

    $this->save('revenue', $userid, $month, $revenue);
    $this->save('varcost', $userid, $month, $variableCost);
    $this->save('fixcost', $userid, $month, $fixedCost);

    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  function updateRevenues($userid, $month, $revenue, $variableCost, $fixedCost) {
    $this->db->trans_start();

    $this->update('revenue', $userid, $month, $revenue);
    $this->update('varcost', $userid, $month, $variableCost);
    $this->update('fixcost', $userid, $month, $fixedCost);

    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  function getRevenue($userid, $month) {
    $data['segment'] = $month;
    $sql = "
        SELECT name, data
        FROM metrics
        WHERE user_id = ?
        AND segment = ?
        AND name in ('revenue', 'varcost', 'fixcost')";
    $query = $this->db->query($sql, array($userid, $month));
    foreach ($query->result_array() as $row) {
      $data[$row['name']] = $row['data'];
    }
    return $data;
  }

  function getRevenueReport($userid) {
    $sql = "
      SELECT r.segment AS month, r.data AS revenue,
             r.data - vc.data AS contribution_margin,
             r.data - vc.data - Coalesce(fc.data, 0) AS net_operating_income
      FROM metrics r
        JOIN metrics vc ON vc.user_id = r.user_id AND vc.segment = r.segment
        LEFT JOIN metrics fc ON fc.user_id = r.user_id AND fc.segment = r.segment AND fc.name = 'fixcost'
      WHERE r.user_id = ?
      AND r.name = 'revenue'
      AND vc.name = 'varcost'
      ORDER BY Str_To_Date(r.segment, '%m/%Y')";
    return $this->db->query($sql, $userid)->result();
  }

  function getCash($userid) {
    $sql = "SELECT * FROM metrics WHERE user_id = ? AND name = 'cash'";
    return $this->db->query($sql, $userid)->row(0);
  }

  function getBurn($userid) {
    $sql = "
      SELECT burn, Date_Format(dt, '%m/%Y') AS month
      FROM (
        SELECT Sum(data) AS burn, Max(Str_To_Date(segment, '%m/%Y')) AS dt
        FROM metrics
        WHERE user_id = ?
        AND name = 'expenses'
      ) x";
    return $this->db->query($sql, $userid)->row(0);
  }

  function getExpense($userid, $month) {
    return $this->db->select('segment, data, description')
      ->where('user_id', $userid)
      ->where('segment', $month)
      ->where('name', 'expenses')
      ->get('metrics')->row();
  }

  function saveCash($userid, $amount) {
    $data = array('user_id' => $userid, 'name' => 'cash', 'data' => $amount);
    return $this->db->insert('metrics', $data);
  }

  function saveExpense($userid, $month, $amount, $description = null) {
    return $this->save('expenses', $userid, $month, $amount, $description);
  }

  function updateExpense($userid, $month, $amount, $description = null) {
    return $this->update('expenses', $userid, $month, $amount, $description);
  }

  function getBurnReport($userid) {
    $sql = "
      SELECT null AS month, 0 AS expenses, data AS cash, description FROM metrics WHERE user_id = ? AND name = 'cash'
      UNION ALL
      SELECT segment AS month, data AS expenses, 0 AS cash, description FROM metrics WHERE user_id = ? AND name = 'expenses'
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

  function getUserbase($userid, $month) {
    $data['segment'] = $month;
    $sql = "
      SELECT name, data
      FROM metrics
      WHERE user_id = ?
      AND segment = ?
      AND name in ('registrations', 'activations', 'retentions30', 'retentions90', 'payingCustomers')";
    $query = $this->db->query($sql, array($userid, $month));
    foreach ($query->result_array() as $row) {
      $data[$row['name']] = $row['data'];
    }
    return $data;
  }

  function saveUserbase($userid, $month, $registrations, $activations, $retentions30, $retentions90, $paying) {
    $this->db->trans_start();

    $this->save('registrations', $userid, $month, $registrations);
    $this->save('activations', $userid, $month, $activations);
    $this->save('retentions30', $userid, $month, $retentions30);
    $this->save('retentions90', $userid, $month, $retentions90);
    $this->save('payingCustomers', $userid, $month, $paying);

    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  function updateUserbase($userid, $month, $registrations, $activations, $retentions30, $retentions90, $paying) {
    $this->db->trans_start();

    $this->update('registrations', $userid, $month, $registrations);
    $this->update('activations', $userid, $month, $activations);
    $this->update('retentions30', $userid, $month, $retentions30);
    $this->update('retentions90', $userid, $month, $retentions90);
    $this->update('payingCustomers', $userid, $month, $paying);

    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  function getUserbaseReport($userid) {
    $sql = "
      SELECT r.segment AS month, r.data AS registrations, a.data AS activations, r30.data AS retentions30,
             r90.data AS retentions90, p.data AS payingCustomers
      FROM metrics r
        JOIN metrics a ON a.user_id = r.user_id AND a.segment = r.segment
        JOIN metrics r30 ON r30.user_id = r.user_id AND r30.segment = r.segment
        JOIN metrics r90 ON r90.user_id = r.user_id AND r90.segment = r.segment
        JOIN metrics p ON p.user_id = r.user_id AND p.segment = r.segment
      WHERE r.user_id = ?
      AND r.name = 'registrations'
      AND a.name = 'activations'
      AND r30.name = 'retentions30'
      AND r90.name = 'retentions90'
      AND p.name = 'payingCustomers'
      ORDER BY Str_To_Date(r.segment, '%m/%Y')";
    return $this->db->query($sql, $userid)->result();
  }

  function getWeb($userid, $month) {
    $query = $this->db->select('name, data')
      ->where('user_id', $userid)
      ->where('segment', $month)
      ->where_in('name', array('uniques', 'pageViews', 'visits'))->get('metrics');
    $ret['segment'] = $month;
    foreach ($query->result_array() as $row) {
      $ret[$row['name']] = $row['data'];
    }
    return $ret;
  }

  function saveWeb($userid, $month, $uniques, $views, $visits) {
    $this->db->trans_start();

    $this->save('uniques', $userid, $month, $uniques);
    $this->save('pageViews', $userid, $month, $views);
    $this->save('visits', $userid, $month, $visits);

    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  function updateWeb($userid, $month, $uniques, $views, $visits) {
    $this->db->trans_start();

    $this->update('uniques', $userid, $month, $uniques);
    $this->update('pageViews', $userid, $month, $views);
    $this->update('visits', $userid, $month, $visits);

    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  function getWebMetricsReport($userid) {
    $sql = "
      SELECT u.segment AS month, u.data AS uniques, p.data AS pageViews, v.data AS visits
      FROM metrics u
        JOIN metrics p ON p.user_id = u.user_id AND p.segment = u.segment
        JOIN metrics v ON v.user_id = u.user_id AND v.segment = u.segment
      WHERE u.user_id = ?
      AND u.name = 'uniques'
      AND p.name = 'pageViews'
      AND v.name = 'visits'
      ORDER BY Str_To_Date(u.segment, '%m/%Y')";
    return $this->db->query($sql, $userid)->result();
  }

  function getAcquisitions($userid, $month) {
    $query = $this->db->select('name, data')
      ->where('user_id', $userid)
      ->where('segment', $month)
      ->where_in('name', array('acqPaidCost', 'acqNetCost', 'ads', 'viratio'))->get('metrics');
    $ret['segment'] = $month;
    foreach ($query->result_array() as $row) {
      $ret[$row['name']] = $row['data'];
    }
    return $ret;
  }

  function saveAcquisitions($userid, $month, $paidCost, $netCost, $adCost, $viralRatio) {
    $this->db->trans_start();

    $this->save('acqPaidCost', $userid, $month, $paidCost);
    $this->save('acqNetCost', $userid, $month, $netCost);
    $this->save('ads', $userid, $month, $adCost);
    $this->save('viratio', $userid, $month, $viralRatio);

    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  function updateAcquisitions($userid, $month, $paidCost, $netCost, $adCost, $viralRatio) {
    $this->db->trans_start();

    $this->update('acqPaidCost', $userid, $month, $paidCost);
    $this->update('acqNetCost', $userid, $month, $netCost);
    $this->update('ads', $userid, $month, $adCost);
    $this->update('viratio', $userid, $month, $viralRatio);

    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  function getAcquisitionCostsReport($userid) {
    $sql = "
      SELECT p.segment AS month, p.data AS paidCost, n.data AS netCost, a.data AS ads, v.data AS viratio
      FROM metrics p
        JOIN metrics n ON n.user_id = p.user_id AND n.segment = p.segment
        JOIN metrics a ON a.user_id = p.user_id AND a.segment = p.segment
        JOIN metrics v ON v.user_id = p.user_id AND v.segment = p.segment
      WHERE p.user_id = ?
      AND p.name = 'acqPaidCost'
      AND n.name = 'acqNetCost'
      AND a.name = 'ads'
      AND v.name = 'viratio'
      ORDER BY Str_To_Date(p.segment, '%m/%Y')";
    return $this->db->query($sql, $userid)->result();
  }
}

