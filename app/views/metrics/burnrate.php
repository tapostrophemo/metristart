<h2>Burn Rate / Expenses <img src="/metrics/burngraph/16" alt="burnrate"/></h2>

<table class="report">
 <tr><th>Month</th><th>Expenses</th><th>Description</th><th>Cash Remaining</th></tr>
<?php foreach ($expenses as $e): ?>
 <tr>
  <td><a href="/expense/<?=$e->month?>" title="edit expense metrics"><?=$e->month?></a></td>
  <td><?=$e->expenses?></td>
  <td><?=$e->description?></td>
  <td><?=$e->cash?></td>
 </tr>
<?php endforeach; ?>
</table>

<a href="/expense">Enter Expenses</a>

