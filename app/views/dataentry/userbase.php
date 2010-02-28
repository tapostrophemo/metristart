<h2>Enter User Base Metrics</h2>

<?=validation_errors()?>

<?=form_open('userbase')?>
<table class="entryForm rounded">
 <tr>
  <td><label>Month</label></td>
  <td><input type="text" name="segment" size="6" value="<?=set_value('segment')?>"/></td>
 </tr>
 <tr>
  <td><label>Registrations</label></td>
  <td><input type="text" name="registrations" size="8" value="<?=set_value('registrations')?>"/></td>
 </tr>
 <tr>
  <td><label>Activations</label></td>
  <td><input type="text" name="activations" size="8" value="<?=set_value('activations')?>"/></td>
 </tr>
 <tr>
  <td><label>Activation/Registration %</label></td>
  <td>X% <small>(on-screen calculation)</small></td>
 </tr>
 <tr>
  <td><label>30-Day Retentions</label></td>
  <td><input type="text" name="retentions30" size="8" value="<?=set_value('retentions30')?>"/></td>
 </tr>
 <tr>
  <td><label>30-Day Retention/Activity %</label></td>
  <td>X% <small>(on-screen calculation)</small></td>
 </tr>
 <tr>
  <td><label>90-Day Retentions</label></td>
  <td><input type="text" name="retentions90" size="8" value="<?=set_value('retentions90')?>"/></td>
 </tr>
 <tr>
  <td><label>90-Day Retention/Activity %</label></td>
  <td>X% <small>(on-screen calculation)</small></td>
 </tr>
 <tr>
  <td><label>Paying Customers</label></td>
  <td><input type="text" name="paying" size="8" value="<?=set_value('paying')?>"/></td>
 </tr>
 <tr>
  <td><label>Num Paying / <br/>(Activations + 30-Day Retained)</label></td>
  <td>X % <small>(on-screen calculation)</small></td>
 </tr>
 <tr>
  <td></td>
  <td>
   <input type="submit" value="Save"/>
   <input type="button" value="Cancel" onclick="location.href='/dashboard'"/>
  </td>
 </tr>
</table>
</form>

<?php $this->load->view('metrics/userbaseDefinitions'); ?>

