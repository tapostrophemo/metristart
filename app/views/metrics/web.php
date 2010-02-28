<h2>Web Metrics</h2>

<table class="report">
 <tr><th>Month</th><th>Uniq. Visitors</th><th>Tot. Page Views</th><th>Tot. Visits</th><th>Page Views/Visit</th></tr>
<?php foreach ($metrics as $m): ?>
 <tr>
  <td><?=$m->month?></td>
  <td><?=$m->uniques?></td>
  <td><?=$m->pageViews?></td>
  <td><?=$m->visits?></td>
  <td><?php printf('%0.1f', $m->pageViews/$m->visits)?></td>
 </tr>
<?php endforeach; ?>
</table>

