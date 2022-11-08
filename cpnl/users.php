<?php
 
	include("header.php");   
	include("classes/Users.php");  
	$db = new DB();
	$userOb = new Users($db); 
	
	
	$msg = "";
	if(isset($_GET["event"]) && $_GET["event"]=="delete")
	{
		$user_id = $_GET["id"] ?? 0;
		$user_name = $_GET["name"] ?? "";
		if($userOb->deleteUser($user_id )){
			$msg = "<div class=\"alert alert-success\" role=\"alert\">
					  User ($user_name ) Deleted Successfully
					</div>";
		}else{
			$msg = "<div class=\"alert alert-info\" role=\"alert\">
					  Couldn't delete user($user_name ) 
					</div>";
		}
	}
	?>
			<script>
			function deleteUser(id , name){
				if (confirm("Are you sure you want to delete this user ("+name+")? ") == true) {
				  window.location.href = "users.php?event=delete&id="+id+"&name="+name;
				}  
			}
			</script>
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Administrator</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Users List</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
								<?=$msg?>
								<div class="card-body">
									<table id="datatablesSimple">
										<thead>
											<tr>
												<th>First Name</th>
												<th>Last Name</th>
												<th>Username</th>   
												<th>Phone</th>
												<th>Email</th>
												<th> User Orders/Tickets</th>
												<th> User Offers/Reselled Tickets</th>
												<th> Delete User</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>First Name</th>
												<th>Last Name</th>
												<th>Username</th>   
												<th>Phone</th>
												<th>Email</th>
												<th> User Orders/Tickets</th>
												<th> User Offers/Reselled Tickets</th>
												<th> Delete User</th>
											</tr>
										</tfoot>
										<tbody>
											<?php
												echo $userOb -> showUsersTable();
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