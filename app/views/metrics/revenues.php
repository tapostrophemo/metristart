<table width="100%"><tr><td>

 <table class="report">
  <tr><th>Month</th><th>Revenue Amt.</th><th>Contrib. Margin</th><th>Net Op. Income</th></tr>
 <?php foreach ($revenues as $r): ?>
  <tr>
   <td><?=$r->month?></td>
   <td><?=$r->revenue?></td>
   <td><?=$r->contribution_margin?></td>
   <td><?=$r->net_operating_income?></td>
  </tr>
 <?php endforeach; ?>
 </table>

</td><td>

 <!-- TODO: generate graph using real data -->
 <img src="/res/wireframes-rev-contribMargin.png" alt="Contribution Margin"/>

</td></tr></table>

