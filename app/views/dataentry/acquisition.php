<h2>Enter Customer Acquisition Metrics</h2>

<?=validation_errors()?>

<?=form_open('acquisition')?>
<table class="entryForm rounded">
 <tr>
  <td><label>Month</label></td>
 <?php if ($editing): ?>
  <td><?=$segment?></td>
 <?php else: ?>
  <td>
   <input type="text" name="segment" size="6" value="<?=set_value('segment')?>"/><br/>
  <?php if (isset($last_entry_date)): ?>
   <small>Last Month Entered: <?=$last_entry_date?></small>
  <?php endif; ?>
  </td>
 <?php endif; ?>
 </tr>
 <tr>
  <td><label>Paid Cost/Acquisition</label></td>
  <td><input type="text" name="acqPaidCost" size="10" value="<?=$editing ? $acqPaidCost : set_value('acqPaidCost')?>"/></td>
 </tr>
 <tr>
  <td><label>Net Cost/Acquisition</label></td>
  <td><input type="text" name="acqNetCost" size="10" value="<?=$editing ? $acqNetCost : set_value('acqNetCost')?>"/></td>
 </tr>
 <tr>
  <td><label>Advertising Expenses</label></td>
  <td><input type="text" name="ads" size="10" value="<?=$editing ? $ads : set_value('ads')?>"/></td>
 </tr>
 <tr>
  <td><label>Viral Ratio</label></td>
  <td><input type="text" name="viratio" size="4" value="<?=$editing ? $viratio : set_value('viratio')?>"/></td>
 </tr>
 <tr>
  <td></td>
  <td>
   <input type="submit" value="Save"/>
   <input type="button" value="Cancel" onclick="location.href='/dashboard'"/>
  </td>
 </tr>
</table>
</table>

<input type="hidden" name="editing" value="<?=$editing ? 1 : 0?>"/>
<?php if ($editing): ?><input type="hidden" name="segment" value="<?=$segment?>"/><?php endif; ?>
</form>

<?php $this->load->view('metrics/acquisitionDefinitions'); ?>

