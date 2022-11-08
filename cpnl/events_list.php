<?php
 
	include("header.php");  
	include("classes/Event.php");  
	$db = new DB();
	$eventOb = new Event($db); 
	$user_id = 0;
	?>
	
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Administrator</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Event List</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
								
								<form action="deleteEvents.php" method="post">
									<div class="card-body">
										<table id="datatablesSimple">
											<thead>
												<tr>
													<th>Event Title</th>
													<th>Event Date</th>   
													<th>Image</th>
													<th>Add Tickets</th>
													<th> Edit</th>
													<th> Select</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Event Title</th>
													<th>Event Date</th> 
													<th>Image</th>
													<th>Add Tickets</th>
													<th> Edit</th>
													<th> Select</th>
												</tr>
											</tfoot>
											<tbody>
												<?php
													echo $eventOb -> showEventsTable();
												?>
											</tbody>
										</table>
									</div>
									
								<input type="submit" class="btn btn-primary" value="Delete Selected" name = "delete"/>
								</form>
                            </div>
                        </div>
					</div>
                </main>
<?php
include("footer.php");

?>   
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>