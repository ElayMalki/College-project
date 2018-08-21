<?php
session_start();

include '../classes/Student.php';
include '../classes/Auth.php';
include '../classes/db.php';

$auth = new Auth();

if( $auth->isLogin() ){ // && ( $auth->getRole() === 1 || $auth->getRole() === 2 ) ) {
    $courses = array();
    $counter = 1;

    $db = new db();
    // get the student id that was sent from the browser
    $student_id = $_POST['student_id'];
    $student_data = array(
        'name' => $_POST['student_name'],
        'phone' => $_POST['student_phone'],
        'email' => $_POST['student_email']
    );


    $student = new Student( $db );
    $student->update( $student_id, $student_data );
    $student->removeCourses( $student_id );
    $student->updateCourses( $student_id, $_POST['courses_checked'] );
    echo json_encode( array( 'status' => "ok" ));
} else {

}

