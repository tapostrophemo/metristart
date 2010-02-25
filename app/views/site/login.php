<h2>Login</h2>

<?=validation_errors()?>

<?=form_open('login')?>
<table class="entryForm rounded">
 <tr>
  <td><label>Username</label></td>
  <td><input type="text" name="username" value="<?=set_value('username')?>"/></td>
 </tr>
 <tr>
  <td><label>Password</label></td>
  <td><input type="password" name="password"/></td>
 </tr>
 <tr>
  <td></td>
  <td><input type="submit" value="Login"/></td>
 </tr>
</table>
</form>

