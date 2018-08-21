<?php
session_start();

include '../classes/Student.php';
include '../classes/Auth.php';
include '../classes/db.php';

$auth = new Auth();

if( $auth->isLogin() && $auth->getRole() < 3  ) {

    $db = new db();
    // get the student id that was sent from the browser
    $student_id = $_POST['student_id'];
    $student = new Student( $db );
    $student->delete( $student_id );
    echo json_encode( array( 'status' => "ok" ));
} else {
    echo json_encode( array( 'status' => "failed" ));
}

