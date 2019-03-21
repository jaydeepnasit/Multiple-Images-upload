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
					<h1 class="head-title">View Images</h1>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="image-viewbox" id="img-pre">

			</div>
		</div>
	</div>
	
	<div class="container-fluid">
		<a class="up-back" href="index.php">
			<i class="fas fa-upload"></i>
		</a>
	</div>

<script src="http://code.jquery.com/jquery-3.3.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>	
<script type="text/javascript">
$(document).ready(function (){
	$('#img-pre').load("load-img.php");

	$(document).on('click', '.img-close', function(){
			var data_val = $(this).data('dataid');
			$.ajax({
				type: "POST",
				url: "ajax-process/img-delete.php",
				data: { 'dataid' : data_val },
				success: function (data) {
					var data = JSON.parse(data);
					if(data.status == 200){
						console.log(data.msg);
						$('#img-pre').load("load-img.php");
					}
					else{
						console.log(data.msg);
					}
				}
			});
	});

});
</script>
</body>
</html>