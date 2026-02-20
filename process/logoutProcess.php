<?php

session_start();

$_SESSION = [];

session_destroy();

setcookie("skillshop_remember", "", time() - 3600, "/");
setcookie("skillshop__user_id", "", time() - 3600, "/");
setcookie("skillshop__user_email", "", time() - 3600, "/");

header("Location: ../index.php?logout-success");

?>
