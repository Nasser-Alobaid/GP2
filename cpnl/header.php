<?php 
	session_start();
	include("classes/DB.php");
	if(!isset($_SESSION['admin']) || gettype($_SESSION['admin'])!="object")
    {
        $currentFile = $_SERVER["PHP_SELF"];
        $parts = Explode('/', $currentFile);
        if($parts[count($parts) - 1] != "login.php")
        	header("location:login.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Re-Ticket</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/customStyle.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Re-Ticket</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
             
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"> 
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
							<div class="mb-4">
								<img src="images/logo.jpeg" style="width: 100%;"/>
							</div> 
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Home
                            </a> 
							
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInsturcotrs" aria-expanded="false" aria-controls="collapseInsturcotrs">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Events
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseInsturcotrs" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="event.php">Add event</a>
                                    <a class="nav-link" href="events_list.php">Events List</a>
                                </nav>
                            </div>
							 
                            <a class="nav-link" href="orders.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                List of sold tickets
                            </a> 
                            <a class="nav-link" href="reselled.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                List of reselled tickets
                            </a> 
							
                            <a class="nav-link" href="users.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                List of users
                            </a> 
							
							  
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-key"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Administrator
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content"> 
