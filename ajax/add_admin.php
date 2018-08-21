<?php
session_start();

include '../classes/Admin.php';
include '../classes/Auth.php';
include '../classes/db.php';

$auth = new Auth();

if( $auth->isLogin() && $auth->getRole() === 1 ) {
    $db = new db();
    $upload_dir = '../images/admins';

    $file_name = time()."_".$_FILES['admin_image']['name'];
    $file_size = $_FILES['admin_image']['size'];
    $file_tmp = $_FILES['admin_image']['tmp_name'];
    $file_type = $_FILES['admin_image']['type'];
    //$file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));

    $extensions= array("jpeg","jpg","png");

    //if(in_array( $file_ext, $extensions )=== false){
    move_uploaded_file( $file_tmp,"$upload_dir/$file_name" );
    //}

    $hash = $auth->getHashPassword( $_POST['admin_password'] );
    $admin_data = array(
        'name' => $_POST['admin_name'],
        'phone' => $_POST['admin_phone'],
        'email' => $_POST['admin_email'],
        'role_id' => $_POST['admin_role_id'],
        'password' => $hash,
        'image_link' => $file_name
    );

    $admin = new Admin( $db );
    $admin_id = $admin->create( $admin_data );

    echo json_encode( array( 'status' => "ok", 'admin_id' => $admin_id, 'image_link' => $file_name  ));
} else {

}

