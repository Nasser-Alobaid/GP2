<?php
 
	include("header.php");  
	include("classes/Users.php");  
	include("classes/Event.php");  
	include("classes/Ticket.php");  
	$db = new DB();
	$addTicket = new Users($db); 
	$event = new Event(); 
	$ticketObj = new Ticket();

	$event_id  = isset($_GET['event_id'])?$_GET['event_id']: 0;  
	$class_type = isset($_POST['class_type'])?$_POST['class_type']:"";
	$price = isset($_POST['price'])?$_POST['price']:""; 
	$qty = isset($_POST['qty'])?$_POST['qty']: 0;
	
	
	$showForm = true;
	$form = "addTicket.php?event_id=".$event_id;
	?>
	
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Administrator</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Add new addTicket</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
				
	
	<?php
	if(isset($_GET['action']) && $_GET['action']=="edit")
	{  

	}else{ 
		if(isset($_POST['qty']) && $price > 0 && $qty > 0 && $event_id > 0)
		{
			 if($ticketObj->addTicket($event_id , $class_type, $price, $qty)){
				echo "<div class='alert alert-success'>Ticket data saved successfully.</div>";
			 }else{
				echo "<div class='alert alert-warning'>Tickets for the selected type is already added.</div>";

			 }
		}  
	}
	
	if($showForm)
	{
		
	?> 
			<div class="card mb-4"> 	
				<div class="card-body">
					<table class="table" id="datatablesSimple">
						<thead>
							<tr>
								<th>Class Type</th>
								<th>Quantity</th>  
								<th>Price</th>  
							</tr>
						</thead> 
						<tbody>
							<?php
								echo $ticketObj->showTickets($event_id);
							?>
						</tbody>
					</table>
				</div> 
			</div>
			<form action="<?=$form ?>" method="post" enctype="multipart/form-data" >
				
			<div class="form-floating mb-3"> 
					<select class="form-control" id="inputClassType" name="class_type"> 
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
					</select>
					<label for="inputClassType">Class Type</label>
				</div>
				
				<div class="form-floating mb-3">
					<input class="form-control" id="inputPrice" name="price" value="<?=$price ?>"  type="number" min="0" required />
					<label for="inputEmail">Ticket Price</label>
				</div>
				 
				
				
				<div class="form-floating mb-3">
					<input class="form-control" id="inputََQTY" name="qty" value="<?=$qty ?>"  type="number" min="0" required />
					<label for="inputََQTY">Number of tickets</label>
				</div>
				 
				
				    
				<div class="mt-4 mb-0">
					<div class="d-grid"><button class="btn btn-primary btn-block" id="save">Save</button></div>
				</div>
			</form>
			

	<?php
	}

?>

                            </div>
                        </div>
					</div>
                </main>
<?php
include("footer.php");

?> 