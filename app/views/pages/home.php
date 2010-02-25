<?php if (!$this->session->userdata('logged_in')): ?>
<a href="/register">Register</a> |
<a href="/login">Login</a>
<?php endif; ?>

