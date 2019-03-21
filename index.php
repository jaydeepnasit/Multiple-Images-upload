<?php

include_once 'config/config.php';
$user_function = new config();

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Image Upload</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" type="text/css">
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
	

	<div class="container-fluid">
		<div class="container">
			<div class="row text-center">
				<div class="col-lg-12">
					<h1 class="head-title">Images Upload</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
				<div class="wrapper">
					<form method="POST" enctype="multipart/form-data" id="formdata">
						<div class="file-upload">
							<input type="file" name="imgfile[]" multiple="multiple" accept="image/x-png,image/gif,image/jpeg" required />
							<i class="far fa-file-image"></i>
						</div>
						<input type="submit" name="submit" class="upload-btn" value="Upload" />
					</form>
				</div>
				</div>
				<div class="col-lg-6 text-center text-light">
					<h3>Image Status</h3>
					<div class="box-fix">
						<div class="box-notification" id="notification">

						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 text-center mt-5" id="set-btn">
					<a class="btn btn-lg btn-outline-light view-button" href="view-images.php">View Images</a>
				</div>
			</div>
		</div>
	</div>
	

	
<script src="http://code.jquery.com/jquery-3.3.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>	

<script type="text/javascript">

$(document).ready(function (){

	$('#formdata').on('submit', function(e){
		e.preventDefault();
		$('#notification').text('');
		var form_data = new FormData($(this)[0]);
		$.ajax({
			type: "POST",
			url: "ajax-process/file-upload.php",
			data: form_data,
			async: false,
			contentType: false,
			cache: false,
			processData: false,
			success: function (data) {
				var data = JSON.parse(data);
				if(data.status == 406){
					console.log(data.msg);
				}
				else if(data.status == 405){
					console.log(data.msg);
				}
				else if(data.status == 404){
					$('#notification').append('<div class="msg-modal bg-danger"> Only 15 Images Allow </div>');
				}
				else{
					if(data.file_success > 0){
						$('#notification').append('<div class="msg-modal bg-success">'+data.file_success+' Images SuccessFully Inserted </div>');
					}
					if(data.file_error > 0){
						$('#notification').append('<div class="msg-modal bg-warning">'+data.file_error+' Images Not Inserted </div>');
					}
					if(data.file_size_error > 0){
						$('#notification').append('<div class="msg-modal bg-danger">'+data.file_size_error+' Images Size is Too Big </div>');
					}
					if(data.file_type_error > 0){
						$('#notification').append('<div class="msg-modal bg-danger">'+data.file_type_error+' Images Type is Invalid </div>');
					}
					if(data.uninterrupted_error > 0){
						$('#notification').append('<div class="msg-modal bg-warning">'+data.uninterrupted_error+' Images Not Inserted </div>');
					}
				}

			}
		});
	});

});

</script>

</body>
</html>
