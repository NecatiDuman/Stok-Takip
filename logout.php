<?php
session_start();
session_destroy();
header("Location: /wms/login.php");
exit;
?>