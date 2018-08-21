<?php
session_start();

include '../classes/Course.php';
include '../classes/Auth.php';
include '../classes/db.php';

$auth = new Auth();

if( $auth->isLogin() && $auth->getRole() < 3  ) {

    $db = new db();
    // get the student id that was sent from the browser
    $course_id = $_POST['course_id'];
    $course = new Course( $db );
    $students = $course->students( $course_id );
    if( count( $students ) === 0 ) {
        $course->delete( $course_id );
    }
    echo json_encode( array( 'status' => "ok" ));
} else {
    echo json_encode( array( 'status' => "failed" ));
}

