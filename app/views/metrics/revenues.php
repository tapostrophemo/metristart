<h2><a href="/metrics/revenues">Revenues <img src="/images/revgraph/16" alt="revenues"/></a></h2>

<table class="report">
 <tr><th>Month</th><th>Revenue Amt.</th><th>Contrib. Margin</th><th>Net Op. Income</th></tr>
<?php foreach ($revenues as $r): ?>
 <tr>
  <td><a href="/revenue/<?=$r->month?>" title="edit revenue metrics"><?=$r->month?></td>
  <td><?=$r->revenue?></td>
  <td><?=$r->contribution_margin?></td>
  <td><?=$r->net_operating_income?></td>
 </tr>
<?php endforeach; ?>
</table>

<?php if ((isset($collapsed) && !$collapsed) || !isset($collapsed)): ?>
<a href="/revenue">Enter Revenues</a>
<?php endif; ?>

