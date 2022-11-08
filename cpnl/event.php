<?php
 
	include("header.php");   
	include("classes/Event.php"); 
	include("classes/upload.php"); 
	$db = new DB(); 
	$event = new Event($db); 
	$event_title  = isset($_POST['event_title'])?$_POST['event_title']:"";  
	$description  = isset($_POST['description'])?$_POST['description']:"";  
	$event_date = isset($_POST['event_date'])?$_POST['event_date']: 0;
	$img_file = isset($_POST['event_title']) ? uploadPDF($_FILES) : "";  
	
	$showForm = true;
	$form = "event.php";
	$imageRequired = " required ";
	?>
	
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Administrator</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Add new event</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
				
	
	<?php
	if(isset($_GET['action']) && $_GET['action']=="edit")
	{
		$event_id = $_GET['event_id'];
		$form = "event.php?action=edit&event_id=".$event_id;
		$imageRequired = "";
		if(isset($_POST['event_title'])  && $event_id > 0)
		{
			$showForm = false;
			if($event->editEvent($event_id ,$event_title ,$description, $event_date, $img_file ))
			{
				echo "<div class='info'>Data updated successfully.</div>";
			}else{
				echo "<div class='info'>Error, please check inputs</div>";
			}
		}else{
			$showForm = true;
			$row = $event->getEvent($event_id);
			$event_title = $row["title"]; 
			$d  = explode(" ",$row["event_date"]);
			$event_date = $d[0]."T".$d[1];
			$description = $row["description"];
			$img_file = $row["img"];
		}
	}else{ 
		if(isset($_POST['event_title']) && $event_date != "" && $img_file != "")
		{
			$showForm = false;
			if($event->addEvent($event_title ,$description, $event_date, $img_file ))
			{
				echo "<div class='info'>Data added successfully to database.</div>";
			}else{
				echo "<div class='info'>Error, couldn't save data.</div>";
			}
		} else{
			if(isset($_POST['event_title']) && $img_file == "")
				echo "<div class='info'>Error, You have to upload the image.</div>";
		}
	}
	
	if($showForm)
	{
		
	?>
			<form action="<?=$form ?>" method="post" enctype="multipart/form-data">
				<div class="form-floating mb-3">
					<input class="form-control" id="inputTitle"  name="event_title" value="<?=$event_title ?>" type="text" required />
					<label for="inputTitle">Event Title</label>
				</div>

				<div class="form-floating mb-3">
					<label for="editor">Description</label></br></br>
					<textarea class="form-control" id="editor"  name="description" ><?=$description ?></textarea>
				</div>
				
				<div class="form-floating mb-3">
					<input class="form-control" id="inputDate"  name="event_date" value="<?=$event_date ?>" type="datetime-local" required />
					<label for="inputDate">Event Date</label>
				</div> 
				
				<div class="form-floating mb-3">
						<input class="form-control" id="img_file"  name="img_file"   type="file"   <?=$imageRequired?> />
						<label for="img_file">Upload Image</label>
				</div>
					
				<div class="mt-4 mb-0">
					<div class="d-grid"><button class="btn btn-primary btn-block">Save</button></div>
				</div>
			</form>
			

	<?php
	}

?>

                            </div>
                        </div>
					</div>
                </main>

<!--
config.language = 'es';
	config.uiColor = '#F7B42C';
	config.height = 300;
	config.toolbarCanCollapse = true;
	-->
	<script src="ckeditor/ckeditor.js"></script>

<script>
	CKEDITOR.replace( 'editor', {
		width: '900',
		height: '400'
	});
	
</script>
<?php
include("footer.php");

?>