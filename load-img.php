<?php

include_once 'config/config.php';
$user_function = new config();

$img_fetch = $user_function->select_order("upload","u_id","DESC");

?>

<?php if($img_fetch){ foreach($img_fetch as $img_data){ ?>
<div class="image-pre-box">
	<div class="img-close" data-dataid="<?php echo $img_data['u_id'] ?>">
        <i class="fas fa-times"></i>
	</div>
	<img src="images/<?php echo $img_data['u_name'] ?>" alt="Image Not Found" class="img-fluid">
</div>
<?php }} ?>