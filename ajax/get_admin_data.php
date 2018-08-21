<?php
session_start();

include '../classes/Admin.php';
include '../classes/Auth.php';
include '../classes/db.php';

$auth = new Auth();

if( $auth->isLogin() === true && $auth->getRole() < 3 ) {
    $db = new db();
    // get the admin id that was sent from the browser
    $admin_id = $_POST['admin_id'];
    // create a new admin object
    $admin = new Admin($db);
    // get the admin data from the DB
    $data = $admin->get( $admin_id );

// encode the result into JSON Format and send it to the browser
    echo json_encode( $data );
}