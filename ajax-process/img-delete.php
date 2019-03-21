<?php

include_once '../config/config.php';
$user_function = new config();

$json_data = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['dataid']) && !empty(trim($_POST['dataid'])) && $_POST['dataid'] > 0){

        $data_id = $user_function->htmlvalidation($_POST['dataid']);

        try{

            $field_data['u_id'] = $data_id;
            $select_img = $user_function->select_where("upload", $field_data);
            $del_img = $select_img['u_name'];
            unlink("../images/".$del_img);
            try{

                $delete_rec = $user_function->delete("upload", $field_data);
                $json_data['status'] = 200;
                $json_data['msg'] = "Image SuccessFully Deleted";

            }
            catch(Exception $ee){

                $json_data['status'] = 201;
                $json_data['msg'] = "Image Not Deleted";

            }

        }
        catch(Exception $e){

            $json_data['status'] = 202;
            $json_data['msg'] = "Image Select Error Found";

        }

    }
    else{

        $json_data['status'] = 203;
        $json_data['msg'] = "Invalid Data Value Not Allow";

    }

}
else{

    $json_data['status'] = 204;
    $json_data['msg'] = "Invalid Request Found";

}


echo json_encode($json_data);


?>