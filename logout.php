<?php
 
$private_page = false;
$showHeader = false;

include("template/session.php");
include("template/header.php");
$_SESSION['user'] = null;
session_destroy(); 
echo " <meta http-equiv='refresh' content='0; url=index.php'> ";
include("template/footer.php");

?>