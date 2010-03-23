<h2>Customer Acquisitions</h2>

<table class="report">
 <tr><th>Month</th><th>Paid Cost / Acquisition</th><th>Net Cost / Acquisition</th><th>Advertising Expenses</th><th>Viral Acquisition Ratio</th></tr>
<?php foreach ($metrics as $m): ?>
 <tr>
  <td><a href="/acquisition/<?=$m->month?>" title="edit customer acquisition metric"/><?=$m->month?></a></td>
  <td><?=$m->paidCost?></td>
  <td><?=$m->netCost?></td>
  <td><?=$m->ads?></td>
  <td><?=$m->viratio?></td>
 </tr>
<?php endforeach; ?>
</table>

<?php $this->load->view('metrics/acquisitionDefinitions'); ?>

