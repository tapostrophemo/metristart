<h2>Admin: User List</h2>

<div id="userDetailDialog" class="rounded dialog">
 <a href="#" class="dialogClose" onclick="$('#userDetailDialog').hide()">close</a>
 <div id="userDetailContent">
 </div>
</div>

<table class="report">
 <tr>
  <th>Username</th>
  <th>Registered</th>
  <th>Last login</th>
 </tr>
<?php foreach ($users as $user): ?>
 <tr>
  <td><a href="/admin/userDetail/<?=$user->id?>"><?=$user->username?></a></td>
  <td><?=$user->registered_at?></td>
  <td><?=$user->last_login_at?></td>
 </tr>
<?php endforeach; ?>
</table>

<script type="text/javascript" src="/res/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {

  jQuery.each($(".report a"), function (i, link) {
    $(link).click(function () {
      $("#userDetailContent").html('<div class="loading"><img src="/res/wait.gif" alt="loading..."/></div>');
      $("#userDetailContent").load(link.href);
      $("#userDetailDialog").show();
      return false;
    });
  });

});
</script>

