<h2>Admin: Backups</h2>

<?=validation_errors();?>

<?=form_open('admin/backup')?>
 <label for="prefix">Filename prefix</label>
 <br/>
 <input type="text" name="prefix"/>
 <br/>
 <input type="submit" value="Download" onclick="this.disabled=true"/>
</form>

<br/>

