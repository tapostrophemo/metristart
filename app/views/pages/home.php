<?php if (!$this->session->userdata('logged_in')): ?>
<div style="text-align:right">
 <?=form_open('login')?>
 <small>
  <label>Username</label> <input type="text" name="username" size="10"/>
  <label>Password</label> <input type="password" name="password" size="10"/>
  <input type="submit" value="Login"/>
 </small>
 </form>
</div>
<?php endif; ?>

<p>MetriStart is a tool that will help you manage the "business" of your web-based startup. It
 shows you what metrics are truly important for this early-stage type of business, allowing you
 to focus on activities that provide the value you need to move your startup forward.</p>

