<h2>Burn Rate / Expenses</h2>

<table class="report">
 <tr><th>Month</th><th>Expenses</th><th>Cash Remaining</th></tr>
<?php foreach ($expenses as $e): ?>
 <tr>
  <td><?=$e->month?></td>
  <td><?=$e->expenses?></td>
  <td><?=$e->cash?></td>
 </tr>
<?php endforeach; ?>
</table>

