<h2>Modify Month</h2>

<?=validation_errors()?>

<?=form_open("/modsegment/${name}/${segment}")?>
<input type="hidden" name="name" value="<?=$name?>"/>
<table class="entryForm rounded">
 <tr>
  <td><label>Old Month</label></td>
  <td><?=$segment?></td>
 </tr>
 </tr>
 <tr>
  <td><label>New Month</label></td>
  <td><input type="text" name="segment" size="6" value="<?=set_value('segment')?>"/></td>
 </tr>
 <tr>
  <td></td>
  <td>
   <input type="submit" value="Save"/>
   <input type="button" value="Cancel" onclick="document.location.href='/dashboard'"/>
  </td>
 </tr>
</table>
</form>

