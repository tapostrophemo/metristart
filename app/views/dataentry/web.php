<h2>Enter Web Metrics</h2>

<?=validation_errors()?>

<?=form_open('web')?>
<table class="entryForm rounded">
 <tr>
  <td><label>Month</label></td>
 <?php if ($editing): ?>
  <td><?=$segment?> <a id="modsegment" title="Alter month" href="/modsegment/web/<?=$segment?>">*</a></td>
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
  <td><label>Total Unique Visitors</label></td>
  <td><input type="text" name="uniques" size="10" value="<?=$editing ? $uniques : set_value('uniques')?>"/></td>
 </tr>
 <tr>
  <td><label>Total Page Views</label></td>
  <td><input type="text" name="views" size="10" value="<?=$editing ? $pageViews : set_value('views')?>"/></td>
 </tr>
 <tr>
  <td><label>Total Visits</label></td>
  <td><input type="text" name="visits" size="10" value="<?=$editing ? $visits : set_value('visits')?>"/></td>
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

