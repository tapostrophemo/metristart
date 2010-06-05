<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>MetriStart.com - Metrics For Your Startup</title>
<link rel="stylesheet" type="text/css" href="/res/main.css"/>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
</head>
<body>

<div id="containerWrapper">
 <div id="container">

  <h1>
   <a href="/">MetriStart - Metrics For Your Startup</a>
  <?php if ($this->session->userdata('logged_in')): ?>
   <div id="usernameTag">logged in as <?=$this->session->userdata('username')?> | <a href="/logout">logout</a></div>
  <?php endif; ?>
  </h1>

  <div id="content">
  <?php if ($this->session->flashdata('err')): ?>
   <div class="err rounded"><?=$this->session->flashdata('err')?></div>
  <?php endif; ?>
  <?php if ($this->session->flashdata('msg')): ?>
   <div class="msg rounded"><?=$this->session->flashdata('msg')?></div>
  <?php endif; ?>

   <?=$content?>
  </div>

 <?php if ($this->session->userdata('logged_in')): ?>
  <a href="/dashboard">Dashboard</a> |
  <a href="/account">Account</a> |
  <?php if ($this->session->userdata('is_admin')): ?><a href="/admin">Admin</a> |<?php endif; ?>
  <a href="/logout">Logout</a>
 <?php else: ?>
  <a href="/register">Register</a> |
  <a href="/login">Login</a>
 <?php endif; ?>

  <div id="footer">
   Copyright &copy; 2010, <a href="http://www.eastofcleveland.com" target="_blank">Dan Parks</a>. All Rights Reserved.
  </div>

 </div>
</div>

<script type="text/javascript">
window.onload = function () {
  if (document.forms && document.forms[0] && document.forms[0].elements[0]) {
    if (document.forms[0].elements[0].type == "text" || document.forms[0].elements[0].type == "password") {
      document.forms[0].elements[0].focus();
    }
  }
};
</script>

</body>
</html>

