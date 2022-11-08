
<!DOCTYPE html>
<html lang="en">
	
<head>
		<title>Re-Ticket</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>  
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="">

		<!--== CSS Files ==-->
		<link href="css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="css/style.css" rel="stylesheet" media="screen">
		<link href="css/font-awesome.css" rel="stylesheet" media="screen">
		<link href="css/owl.carousel.css" rel="stylesheet" media="screen">
		<link href="css/flexslider.css" rel="stylesheet" media="screen">
		<link href="css/fancySelect.css" rel="stylesheet" media="screen">
		<link href="css/responsive.css" rel="stylesheet" media="screen">

		<!--== Google Fonts ==-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Belgrano' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

		<script>
			function goEvent(id){
				window.location.href = "event_details.php?id="+id;
			}
			function goCart(){
				window.location.href = "cart.php";
			}
			function goLink(link){
				window.location.href = link;
			}
		</script>
		
		<style>
		.btn {
		  background-color: #008CBA;  
		  border: none;
		  color: white;
		  padding: 15px 32px;
		  text-align: center;
		  text-decoration: none;
		  display: inline-block;
		  font-size: 16px;
		}
		.btn-red{
		  background-color: #f44336;   
		} 
		.dropdown1 {
		  position: relative;
		  display: inline-block;
		  padding: 8px;
		}

		.dropdown-content {
		  display: none;
		  position: absolute;
		  background-color: #f9f9f9;
		  min-width: 160px;
		  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		  right: 0px;
		  z-index: 1000;
		}

		.dropdown1:hover .dropdown-content {
		  display: block;
		}
		
		#header { 
			overflow: visible;
		}
</style>

	</head>
	<body>
		<header id="header">
			<div id="menu" class="header-menu fixed">
				<div class="box">
					<div class="row">
						<nav role="navigation" class="col-sm-12">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>

								<!--== Logo ==-->
								<span class="navbar-brand logo">
									Re-Ticket
								</span>

							</div>
									
							<div class="navbar-collapse collapse">

								<!--== Navigation Menu ==-->
								<ul class="nav navbar-nav">
									<li ><a href="index.php#header" onclick="goLink('index.php#header')">Home</a></li>
									<li><a href="index.php#events" onclick="goLink('index.php#events')">Events</a></li> 
									<li><a href="reselled_ticktes.php"  onclick="goLink('reselled_ticktes.php')">Reselled Ticktes</a></li> 
									<li><a href="index.php#about"  onclick="goLink('index.php#about')">About us</a></li> 
									<li><a href="index.php#contact"  onclick="goLink('index.php#contact')">Contact</a></li>
									
									<?php									
										if(isset($_SESSION["user"])){
											?>
												<div class="dropdown1">
												  <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
												  <div class="dropdown-content">
													<ul class="dropdown-menu" >
																
																<li><a href="cart.php"  onclick="goLink('cart.php')">View Cart</a></li> 
																<li><a href="myOrders.php"  onclick="goLink('myOrders.php')">My Tickets</a></li> 
																<li><a href="myOffers.php"  onclick="goLink('myOffers.php')">My Offers</a></li> 
																<li class="divider"></li>
																<li><a href="logout.php"  onclick="goLink('logout.php')">Logout [<?=$userData["fname"]?>]</a></li>  
															</ul>
												  </div>
												</div> 		 
<!--											
											<li><a href="cart.php"  onclick="goLink('cart.php')">View Cart</a></li> 
											<li><a href="myOrders.php"  onclick="goLink('myOrders.php')">My Tickets</a></li> 
											<li><a href="logout.php"  onclick="goLink('logout.php')">Logout [<?=$userData["fname"]?>]</a></li> 
											
											-->
											<?php
										}else{
											?>
											<li><a href="login.php"  onclick="goLink('login.php')">login</a></li>  
											<?php
										}
									?>
								</ul>
							</div>
						</nav>
					</div>
				</div>
			</div>
			<?php
			if($showHeader){
				?>
			<!--== Site Description ==-->
			<div class="header-cta">
				<div class="container">
					<div class="row">
						<div class="entry-content">
				            <p><span class="start-text"><b>All tickets in one place</b></span></p>
				            <h4 class="entry-title"><a href="#">Find best class events</a></h4>
				            <h5><span><b> </b></span></h5>
					    </div>
					</div>
				</div>
			</div>

			<div class="header-bg">
				<div id="preloader">
					<div class="preloader"></div>
				</div>
				<div class="main-slider" id="main-slider">

					<!--== Main Slider ==-->
					<ul class="slides">
						<li><img src="images/demo/bg-slide-01.jpg" alt="Slide Image"/></li>
						<li><img src="images/demo/bg-slide-02.jpg" alt="Slide Image 2"/></li>
					</ul>

				</div>
			</div>
			<?php
			}else{
				echo '
			<div style="height: 100px;"></div>';
			}
				?>
		</header>

		<div class="content">
			<div class="container box">


			<?php
			if($showHeader){
				?>
				<!--===============================-->
				<!--== About us ===================-->
				<!--===============================-->
		<section id="about" class="about-us">
			<div class="title-start col-md-4 col-md-offset-4">
			<br />
				<h2>About Us</h2>
				<p class="sub-text text-center">Know our great story</p>
			</div>
			<div class="container"> 
			
				<div class="about-part">
					<div class="col-md-12">
					
						<h3>ABOUT US</h3>
						

						<p>Change this text</p>
					</div> 
				</div>
			</div>
		</section>
				<!--==========-->

			<?php
			}
				?>