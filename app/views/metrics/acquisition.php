<h2><a href="/metrics/acq">Customer Acquisitions <img src="/images/acqgraph/16" alt="acquisitions"/></a></h2>

<table class="report">
 <tr><th>Month</th><th>Paid Cost / Acquisition</th><th>Net Cost / Acquisition</th><th>Advertising Expenses</th><th>Viral Acquisition Ratio</th></tr>
<?php foreach ($acquisition as $a): ?>
 <tr>
  <td><a href="/acquisition/<?=$a->month?>" title="edit customer acquisition metric"/><?=$a->month?></a></td>
  <td><?=$a->paidCost?></td>
  <td><?=$a->netCost?></td>
  <td><?=$a->ads?></td>
  <td><?=$a->viratio?></td>
 </tr>
<?php endforeach; ?>
</table>

<?php if ((isset($collapsed) && !$collapsed) || !isset($collapsed)): ?>
<?php $this->load->view('metrics/acquisitionDefinitions'); ?>
<a href="/acquisition">Enter Acquisition Metrics</a>
<?php endif; ?>

