<h2>User Base</h2>

<table class="report" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <th>Month</th>
  <th>Registrations</th>
  <th>Activations</th>
  <th>Activation / Registration %</th>
  <th>30-Day Retention</th>
  <th>30-Day Ret. / Total Activity %</th>
  <th>90-Day Retention</th>
  <th>90-Day Ret. / Total Activity %</th>
  <th>Paying Customers</th>
  <th>Paying Cust. / (Activations + 30-Day Ret.)</th>
 </tr>
<?php foreach ($userbase as $r): $tot = $r->registrations+$r->activations+$r->payingCustomers?>
 <tr>
  <td><a href="/userbase/<?=$r->month?>" title="edit userbase metrics"><?=$r->month?></a></td>
  <td><?=$r->registrations?></td>
  <td><?=$r->activations?></td>
  <td><?php if ($r->registrations > 0) printf('%0.1f', $r->activations/$r->registrations*100); else echo 0; ?></td>
  <td><?=$r->retentions30?></td>
  <td><?php if ($tot > 0) printf('%0.1f', $r->retentions30/$tot*100); else echo 0; ?></td>
  <td><?=$r->retentions90?></td>
  <td><?php if ($tot > 0) printf('%0.1f', $r->retentions90/$tot*100); else echo 0; ?></td>
  <td><?=$r->payingCustomers?></td>
  <td><?php if (($r->activations+$r->retentions30) > 0) printf('%0.1f', $r->payingCustomers/($r->activations+$r->retentions30)); else echo 0; ?></td>
 </tr>
<?php endforeach; ?>
</table>

<?php $this->load->view('metrics/userbaseDefinitions'); ?>

<a href="/userbase">Enter User Base Metrics</a>

