<?php
session_start();

include '../classes/Course.php';
include '../classes/Auth.php';
include '../classes/db.php';

$auth = new Auth();

if( $auth->isLogin() ) {
    $db = new db();
    // get the course id that was sent from the browser
    $course_id = $_POST['course_id'];
    // create a new course object
    $course = new Course($db);
    // get the course data from the DB
    $info = $course->get_by_id( $course_id );
    $students = $course->students( $course_id );

    // encode the result into JSON Format and send it to the browser
    echo json_encode( array('info' => $info, 'students' => $students) );
}