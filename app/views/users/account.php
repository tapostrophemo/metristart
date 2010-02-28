<h2>Account</h2>

<?=validation_errors()?>

<?=form_open('account')?>
<table class="entryForm rounded">
 <tr>
  <td><label>Username</label></td>
  <td><?=$account->username?></td>
 </tr>
 <tr>
  <td><label>Registered</label></td>
  <td><?=$account->registered_at?></td>
 </tr>
 <tr>
  <td><label>Last Login</label></td>
  <td><?=$account->last_login_at?></td>
 </tr>
 <tr>
  <td><label>Email</label></td>
  <td><input type="text" name="email" value="<?=set_value('email', $account->email)?>"/></td>
 </tr>
 <tr><td colspan="2" class="toc">&nbsp;</td></tr>
 <tr>
  <td><label>Reset Password</label></td>
  <td><input type="password" name="password"/></td>
 </tr>
 <tr>
  <td><label>Confirm Password</label></td>
  <td><input type="password" name="passconf"/></td>
 </tr>
 <tr>
  <td></td>
  <td>
   <input type="submit" value="Update"/>
   <input type="button" value="Cancel" onclick="location.href='/dashboard'"/>
  </td>
 </tr>
</table>
</form>

