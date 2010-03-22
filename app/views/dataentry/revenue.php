<h2>Enter Revenue</h2>

<?=validation_errors()?>

<?=form_open('revenue')?>
<table class="entryForm rounded">
 <tr>
  <td><label>Month</label></td>
 <?php if ($editing): ?>
  <td><?=$segment?></td>
 <?php else: ?>
  <td><input type="text" name="segment" size="6" value="<?=set_value('segment')?>"/></td>
 <?php endif; ?>
 </tr>
 <tr>
  <td><label>Total Revenue</label></td>
  <td><input type="text" name="revenue" size="10" value="<?=$editing ? $revenue : set_value('revenue')?>"/></td>
 </tr>
 <tr>
  <td><label>Total Variable Costs</label></td>
  <td><input type="text" name="varcost" size="10" value="<?=$editing ? $varcost : set_value('varcost')?>"/></td>
 </tr>
 <tr>
  <td><label>Contribution Margin</label></td>
  <td>$0 <small>(on-screen calculation)</small></td>
 </tr>
 <tr><td colspan="2"><hr size="1"/></td></tr>
 <tr>
  <td><label>Total Fixed Costs</label></td>
  <td><input type="text" name="fixcost" size="10" value="<?=$editing && isset($fixcost) ? $fixcost : set_value('fixcost')?>"/></td>
 </tr>
 <tr>
  <td><label>Net Operating Income</label></td>
  <td>$0 <small>(on-screen calculation)</small></td>
 </tr>
 <tr>
  <td></td>
  <td>
   <input type="submit" value="Save"/>
   <input type="button" value="Cancel" onclick="location.href='/dashboard'"/>
  </td>
 </tr>
</table>

<input type="hidden" name="editing" value="<?=$editing ? 1 : 0?>"/>
<?php if ($editing): ?><input type="hidden" name="segment" value="<?=$segment?>"/><?php endif; ?>
</form>

