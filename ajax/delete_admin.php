<?php
session_start();

include '../classes/Admin.php';
include '../classes/Auth.php';
include '../classes/db.php';

$auth = new Auth();

if( $auth->isLogin() && $auth->getRole() === 1  ) {

    $db = new db();
    // get the student id that was sent from the browser
    $admin_id = $_POST['admin_id'];
    $admin = new Admin( $db );
    $current_admin = $admin->get( $admin_id );
    if( $current_admin['role_id'] > 1 ) {
        $admin->delete($admin_id);
        echo json_encode( array( 'status' => "ok" ));
    } else {
        echo json_encode( array( 'status' => "failed" ));
    }

} else {
    echo json_encode( array( 'status' => "failed" ));
}

