<?php

	session_start(); 
	if(!isset($_SESSION['user']) || gettype($_SESSION['user'])!="object")
    {
		if($private_page){
			$currentFile = $_SERVER["PHP_SELF"];
			$parts = Explode('/', $currentFile);
			if($parts[count($parts) - 1] != "login.php")
				header("location:login.php");
		}
    }
    
?>