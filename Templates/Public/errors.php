<?php  if ($_COOKIE["reason"]): ?>
  <div class="error">
  	  <p><?php echo $_COOKIE["reason"]; setcookie("reason", false) ?></p>
  </div>
<?php  endif ?>