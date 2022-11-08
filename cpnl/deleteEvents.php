<?php
	
	include("header.php");   
	include("classes/Event.php"); 
	include("classes/upload.php"); 
	$db = new DB(); 
	$event = new Event($db); 
	
	?>
	
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Administrator</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Delete Events</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
				
				
	
	<?php
	if(isset($_POST['delete']) || isset($_POST['yes'])|| isset($_POST['no']))
	{
		if(isset($_POST['yes']))
		{
			$delete = true;
			for($i=0; $i< sizeof($_POST["event_id"]); $i++)
			{
				if($event->deleteEvent($_POST["event_id"][$i])){
					echo "<div class='warning-info'>Event (".$_POST["event_id"][$i] .") is deleted successfully.</div>";
				}else{
					$delete = false;
				}
			}
			if($delete)
			{
				echo "<meta http-equiv='refresh' content='5; url=events_list.php?deletemsg=true'>";
			}
		}else if(isset($_POST['no'])){
			echo "<meta http-equiv='refresh' content='0; url=events_list.php'>";
		}else{
	?>
			<form action="" method="post" enctype="multipart/form-data">
				<table width="648" border="0">                                 
				  <tr>
					<td width="115">Are you sure to delete selected event/s?</td>
					<?php
					for($i=0; $i< sizeof($_POST["evID"]); $i++)
					{
						$eventID = $_POST["evID"][$i];
						$index = "evID_".$eventID;
						if(isset($_POST[$index ]) ) 
						{
							echo "<input type='hidden' name='event_id[]' value='$eventID'/>";
						}
					}
					?>
				  </tr>				  
				  <tr>
					<td>
						<input type="submit" class="btn btn-default" value="   Confirm   " name="yes"/>
						<input type="submit" class="btn btn-default" value="   Cancel   " name="no"/>					
					</td>
				  </tr>
				</table>
			</form>
	<?php
		}
	}
	?>

                            </div>
                        </div>
					</div>
                </main>

	<?php

include("footer.php");

?>