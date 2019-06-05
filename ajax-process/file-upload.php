<?php

include_once '../config/config.php';
$user_Function = new config();

$json = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_FILES['imgfile']) && !empty($_FILES['imgfile'])){

        $file_name = $_FILES['imgfile']['name'];
        $file_type = $_FILES['imgfile']['type'];
        $file_location = $_FILES['imgfile']['tmp_name'];
        $file_error = $_FILES['imgfile']['error'];
        $file_size = $_FILES['imgfile']['size'];

        $accept_image = array("image/png", "image/jpeg", "image/gif");
        $accept_ext = array('png', 'jpg', 'jpeg', 'gif');
        $total_image = count($file_name);

        if($total_image <= 15){

            $file_success = 0;
            $file_error = 0;
            $file_size_error = 0;
            $file_type_error = 0;
            $uninterrupted_error = 0;

            for($i=0; $i<$total_image; $i++){

                if($file_error[$i] == 0){

                    if($file_size[$i] <= 2097152){

                        $img_file_ext = strtolower(pathinfo($file_name[$i], PATHINFO_EXTENSION));

                        if(in_array($file_type[$i], $accept_image) && in_array($img_file_ext, $accept_ext) && @getimagesize($file_location[$i])){

                            $img_new_file_name = trim(strtolower(pathinfo($file_name[$i], PATHINFO_BASENAME)));
                            $img_new_file_name = mt_rand(10000000, 99999999).time().date('ymdhis').'.'.$img_file_ext;
                            
                            $field_data['u_name'] = $img_new_file_name;
                            $field_data['u_date'] = date('Y-m-d');

                            try{

                                $insert_files = $user_Function->insert("upload", $field_data);
                                move_uploaded_file($file_location[$i], "../images/$img_new_file_name");

                                $file_success++;
                                $json['file_success_msg'] = "Files SuccessFully Inserted";
                                $json['file_success'] = $file_success;
                                
                            }
                            catch(Exception $e){

                                $uninterrupted_error++;
                                $json['uninterrupted_error_msg'] = "File Has Not Inserted";
                                $json['uninterrupted_error'] = $uninterrupted_error;

                            }

                        }
                        else{

                            $file_type_error++;
                            $json['file_type_msg'] = "Only JPG, PNG & GIF Allow";
                            $json['file_type_error'] = $file_type_error;

                        }

                    }
                    else{

                        $file_size_error++;
                        $json['file_size_msg'] = "Bigger Than 2 MB Image Not Allow";
                        $json['file_size_error'] = $file_size_error;

                    }

                }
                else{

                    $file_error++;
                    $json['file_error_msg'] = "Images Not Inserted";
                    $json['file_error'] = $file_error;

                }

            }

        }
        else{

            $json['status'] = 404;
            $json['msg'] = "Only 15 Images Allow";

        }


    }
    else{
        
        $json['status'] = 405;
        $json['msg'] = "Invalid Data Request Not Allow"; 

    }

}
else{

    $json['status'] = 406;
    $json['msg'] = "Invalid Request Not Allow ";

}


echo json_encode($json);

?>
