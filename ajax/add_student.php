<?php
session_start();

include '../classes/Student.php';
include '../classes/Auth.php';
include '../classes/db.php';

$auth = new Auth();

if( $auth->isLogin() && ( $auth->getRole() === 1 || $auth->getRole() === 2 ) ) {
    $db = new db();
    $student_data = array(
        'name' => $_POST['student_name'],
        'phone' => $_POST['student_phone'],
        'email' => $_POST['student_email']
    );

    $student = new Student( $db );
    $student_id = $student->create( $student_data );

    echo json_encode( array( 'status' => "ok", 'student_id' => $student_id ));
} else {

}

