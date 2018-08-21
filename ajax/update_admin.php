<?php
session_start();

include '../classes/Admin.php';
include '../classes/Auth.php';
include '../classes/db.php';

$auth = new Auth();

if( $auth->isLogin() ) {
    $db = new db();
    $admin = new Admin($db);
    $role = $auth->getRole();
    $admin_id = $_POST['admin_id'];
    $my_user_id = $auth->getId();
    if( $role === 1 || ( $role === 2 && $my_user_id == $admin_id ) ) {

        $file_name = false;
        // check if the admin send an image
        if (!empty($_FILES['admin_image']['name'])) {
            $upload_dir = '../images/admins';
            $file_name = time() . "_" . $_FILES['admin_image']['name'];
            $file_size = $_FILES['admin_image']['size'];
            $file_tmp = $_FILES['admin_image']['tmp_name'];
            $file_type = $_FILES['admin_image']['type'];
            //$file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));

            $extensions = array("jpeg", "jpg", "png");
            move_uploaded_file($file_tmp, "$upload_dir/$file_name");
        }


        $current_admin = $admin->get($admin_id);
        // delete previous image
        if ($file_name !== false) {
            // delete current course's image
            unlink($upload_dir . '/' . $current_admin['image_link']);
        } else {
            $file_name = $current_admin['image_link'];
        }


        $hash = "";
        if (strlen($_POST['admin_password']) > 0 && ($auth->getRole() === 1)) {
            $hash = $auth->getHashPassword($_POST['admin_password']);
        }

        $admin_data = array(
            'name' => $_POST['admin_name'],
            'phone' => $_POST['admin_phone'],
            'email' => $_POST['admin_email'],
            'password' => $hash,
            'image_link' => $file_name,
            'id' => $admin_id
        );

        $sql = $admin->update($admin_id, $admin_data);

        echo json_encode(array('status' => "ok", 'admin_id' => $admin_id, 'image_link' => $file_name));
    } else {
        echo json_encode(array('status' => "failed" ));
    }
}

