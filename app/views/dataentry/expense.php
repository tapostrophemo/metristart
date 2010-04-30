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

<h2>Enter Expenses</h2>

<?=validation_errors()?>

<?=form_open('expense')?>
<table class="entryForm rounded">
 <tr>
  <td><label>Month</label></td>
 <?php if ($editing): ?>
  <td><?=$expenses->segment?></pre></td>
 <?php else: ?>
  <td>
   <input type="text" name="segment" size="6" value="<?=set_value('segment')?>"/><br/>
  <?php if (isset($burn->month)): ?>
   <small>Last Month Entered: <?=$burn->month?></small>
  <?php endif; ?>
  </td>
 <?php endif; ?>
 </tr>

<?php if (!$editing): ?>
 <tr>
  <td><label>Remaining Previous Month</label></td>
 <?php if (isset($burn->burn)): ?>
  <td>$<?=$cash->data - $burn->burn?></td>
 <?php else: ?>
  <td>$<?=$cash->data?> <small>(initial cash infusion)</small></td>
 <?php endif; ?>
 </tr>
<?php endif; ?>

 <tr>
  <td><label>Total Expenses</label></td>
  <td><input type="text" name="expenses" size="10" value="<?=$editing ? $expenses->data : set_value('amount')?>"/></td>
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

<input type="hidden" name="editing" value="<?=$editing ? 1 : 0?>"/>
<?php if ($editing): ?><input type="hidden" name="segment" value="<?=$expenses->segment?>"/><?php endif; ?>
</form>

