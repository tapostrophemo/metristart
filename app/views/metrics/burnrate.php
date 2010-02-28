<table width="100%"><tr><td>

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

</td><td>

 <!-- TODO: generate graph using real data -->
 <img src="/res/wireframes-burnRate.png" alt="Burn Rate"/>

</td></tr></table>

