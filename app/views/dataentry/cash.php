<?php if (count($cash) != 1): ?>

<h2>Enter Inintial Cash Infusion</h2>

<?=validation_errors()?>

<?=form_open('infusion')?>
<table class="entryForm rounded">
 <tr>
  <td><label>Amount</label></td>
  <td><input type="text" name="amount" size="10" value="<?=set_value('amount')?>"/></td>
 </tr>

<?php else: ?>

<h2>Enter Cash</h2>

<?=validation_errors()?>

<?=form_open('cash')?>
<table class="entryForm rounded">
 <tr>
  <td><label>Month</label></td>
  <td><input type="text" name="segment" size="6" value="<?=set_value('segment')?>"/></td>
 </tr>
 <tr>
  <td><label>Remaining Previous Month</label></td>
 <?php if (isset($burn->burn)): ?>
  <td>$<?=$cash->data - $burn->burn?> <small>(as of <?=$burn->month?>)</small></td>
 <?php else: ?>
  <td>$<?=$cash->data?> <small>(initial cash infusion)</small></td>
 <?php endif; ?>
 </tr>
 <tr>
  <td><label>Total Expenses</label></td>
  <td><input type="text" name="expenses" size="10" value="<?=set_value('amount')?>"/></td>
 </tr>

<?php endif; ?>

 <tr>
  <td></td>
  <td>
   <input type="submit" value="Save"/>
   <input type="button" value="Cancel" onclick="location.href='/dashboard'"/>
  </td>
 </tr>
</table>
</form>

