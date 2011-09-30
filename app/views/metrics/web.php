<h2><a href="/metrics/wb">Web Metrics <img src="/images/webgraph/16" alt="web metrics"/></a></h2>

<table class="report">
 <tr><th>Month</th><th>Uniq. Visitors</th><th>Tot. Page Views</th><th>Tot. Visits</th><th>Page Views/Visit</th></tr>
<?php foreach ($web as $w): ?>
 <tr>
  <td><a href="/web/<?=$w->month?>" title="edit web metrics"><?=$w->month?></a></td>
  <td><?=$w->uniques?></td>
  <td><?=$w->pageViews?></td>
  <td><?=$w->visits?></td>
  <td><?php printf('%0.1f', $w->pageViews/$w->visits)?></td>
 </tr>
<?php endforeach; ?>
</table>

<?php if ((isset($collapsed) && !$collapsed) || !isset($collapsed)): ?>
<a href="/web">Enter Web Metrics</a>
<?php endif; ?>

