<?php 

include("header.php");


include("classes/Event.php");
include("classes/Ticket.php");
include("classes/Users.php"); 
include("classes/Cart.php");
include("classes/Order.php");

 
$db = new DB();  

$userOb = new Users($db);
$eventOb = new Event();
$ticketOb = new Ticket();
$cartOb = new Cart();
$orderOb = new Order($cartOb , $ticketOb );
  
$user_id = $_GET["user_id"] ?? 0;
$msg = ""; 
$title = 'List of All Sold Tickets';
if($user_id > 0){
	$userData = $userOb->getUser($user_id);
	$name = $userData["fname"]." ".$userData["lname"];
	$title = "List of Sold Tickets for user ($name)";
}
?> 
			
	
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Administrator</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
							<li class="breadcrumb-item active"><?=$title?></li>
                        </ol>
						
                        <div class="card mb-4">
                            <div class="card-body">
								<?php
								if($user_id>0){
									?>
								<div class="card">
									<h2>User Info</h2>
									<ul>
										<li>User Name: <?=$name?></li>
										<li>User Email: <?=$userData["email"]?></li>
										<li>User Phone: <?=$userData["phone"]?></li>
									</ul>
								</div>
								<?php
								}
								?>
								<div class="card-body">
									<table id="datatablesSimple">
									
										<thead>
											<tr>
												<th>Customer Name</th>
												<th>Phone</th>
												<th>Email</th>
												<th>Event</th>
												<th>Event Date</th>
												<th>Sold Qty</th>
												<th>Class Type</th>
												<th>Order Date</th>
												<th>Ticket Price</th> 
												<th>Reselled</th> 
											</tr>
										</thead>
										<tfoot>
											<tr>															
												<th>Customer Name</th>
												<th>Phone</th>
												<th>Email</th>
												<th>Event</th>
												<th>Event Date</th>
												<th>Sold Qty</th>
												<th>Class Type</th>
												<th>Order Date</th>
												<th>Ticket Price</th> 
												<th>Reselled</th> 
											</tr>
										</tfoot>
										<tbody> 
										<?php
											echo  $orderOb->getOrderdTickets($user_id, true , $userOb);
										?>
										</tbody>
									</table>
								</div>

                            </div>
                        </div>
					</div>
                </main>
<?php
include("footer.php");

?>   
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>