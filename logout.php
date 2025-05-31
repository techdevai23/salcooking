<?php
require_once 'controllers/session.php';
logout();
header("Location: index.php");
exit();
?>