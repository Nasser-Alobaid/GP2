<?php
$private_page = false;
$showHeader = true;
include("cpnl/classes/DB.php");
include("cpnl/classes/Event.php");
include("cpnl/classes/Ticket.php");
include("cpnl/classes/Users.php");


include("template/session.php");

$db = new DB(); 
if(isset($_SESSION["user"])){
	$u = $_SESSION["user"];
	$user_id = $u->getUserID();  
	$user = new Users($db );
	$userData = $user->getUser($user_id);
}



include("template/header.php");


$eventOb = new Event($db);

$eventsList = $eventOb ->getNewEvents();
?>

 

				<!--===============================-->
				<!--== Events =============-->
				<!--===============================-->
			<section id="events" class="row">
				<div class="title-start col-md-4 col-md-offset-4"><h2>Events</h2>	
				<p class="sub-text text-center">New Events</p>	
				</div>
				<div class="top">
				</div>
				<div class="content">
				  <?php
				  
				  if(sizeof($eventsList) > 0){
					foreach($eventsList as $event){
						?>
						<div class="blog col-md-4">
							<h2 class="blog-head"><?=$event["title"]?></h2>
							<h3>
							Event on <span class="date-line"><?=$event["event_date"]?></span>
							</h3>
							</h3>
							<img class="blog-image" src="imgs/<?=$event["img"]?>" width="100%" height="250" alt="Blog Image 2"/>
							
							<p class="firstpara"><?=$event["description"]?></p> 

							<button onclick="goEvent(<?=$event["id"]?>)"  class="button-info read-more">Read More</button>
							 
						  </div>
						<?php
					}
				  
				  }
				  ?>
				   
			</section>
<?php
include("template/footer.php");
?>