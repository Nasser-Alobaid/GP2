<?php
 
include("header.php");
$_SESSION['admin'] = null;
session_destroy(); 
echo " <meta http-equiv='refresh' content='0; url=index.php'> ";
include("footer.php");

?>