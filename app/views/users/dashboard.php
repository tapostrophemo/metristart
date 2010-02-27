<table border="0" width="100%" cellpadding="0" cellspacing="0">
 <tr>
  <th>Financials</th>
  <th>Cash</th>
 </tr>
 <tr>
  <td width="50%">
   <img src="/res/wireframes-rev-contribMargin.png" alt="Contribution Margin"/><br/>
   <img src="/metrics/revgraph/16" alt="revenue"/><br/>
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
  </td>
  <td>
   <img src="/res/wireframes-burnRate.png" alt="Burn Rate"/>
  </td>
 </tr>
</table>

<a href="/pages/wireframes">See what we're up to!</a> |
<a href="/revenue">Enter Revenues</a>

