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
  <td><?=$r->month?></td>
  <td><?=$r->registrations?></td>
  <td><?=$r->activations?></td>
  <td><?php printf('%0.1f', $r->activations/$r->registrations*100)?></td>
  <td><?=$r->retentions30?></td>
  <td><?php printf('%0.1f', $r->retentions30/$tot*100)?></td>
  <td><?=$r->retentions90?></td>
  <td><?php printf('%0.1f', $r->retentions90/$tot*100)?></td>
  <td><?=$r->payingCustomers?></td>
  <td><?php printf('%0.1f', $r->payingCustomers/($r->activations+$r->retentions30))?></td>
 </tr>
<?php endforeach; ?>
</table>


<p><b>Definitions</b> (see also <a href="http://steveblank.com/2010/02/22/no-accounting-for-startups/" target="_blank">this article</a>):</p>
<dl>
 <dt>Registrations</dt><dd>Customers who completed the registration process during the month</dd>
 <dt>Activations</dt><dd>Customers who had activity 3 to 10 days after they registered. Measures only customers that registered during that month</dd>
 <dt>Total Activity</dt><dd>Registrations + Activations + Paid Orders (TODO: we only track paying customers?)</dd>
</dl>

