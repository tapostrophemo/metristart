<h2>Enter Customer Acquisition Metrics</h2>

<?=validation_errors()?>

<?=form_open('acquisition')?>
<table class="entryForm rounded">
 <tr>
  <td><label>Month</label></td>
  <td><input type="text" name="segment" size="6" value="<?=set_value('segment')?>"/></td>
 </tr>
 <tr>
  <td><label>Paid Cost/Acquisition</label></td>
  <td><input type="text" name="acqPaidCost" size="10" value="<?=set_value('acqPaidCost')?>"/></td>
 </tr>
 <tr>
  <td><label>Net Cost/Acquisition</label></td>
  <td><input type="text" name="acqNetCost" size="10" value="<?=set_value('acqNetCost')?>"/></td>
 </tr>
 <tr>
  <td><label>Advertising Expenses</label></td>
  <td><input type="text" name="ads" size="10" value="<?=set_value('ads')?>"/></td>
 </tr>
 <tr>
  <td><label>Viral Ratio</label></td>
  <td><input type="text" name="viratio" size="4" value="<?=set_value('viratio')?>"/></td>
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
</form>

<?php $this->load->view('metrics/acquisitionDefinitions'); ?>

