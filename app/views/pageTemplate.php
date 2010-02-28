<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>MetriStart.com - Metrics For Your Startup</title>
<link rel="stylesheet" type="text/css" href="/res/main.css"/>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
</head>
<body>

<div id="containerWrapper">
 <div id="container">

  <h1><a href="/">MetriStart - Metrics For Your Startup</a></h1>

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

</body>
</html>

