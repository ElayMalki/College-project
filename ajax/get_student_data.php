<?php
session_start();

include '../classes/Student.php';
include '../classes/Auth.php';
include '../classes/db.php';

$auth = new Auth();

if( $auth->isLogin() === true ) {
    $db = new db();
// get the student id that was sent from the browser
    $student_id = $_POST['student_id'];
// create a new student object
    $student = new Student($db);
// get the studetn data from the DB
    $info = $student->get_by_id($student_id);
// get student's courses
    $courses = $student->courses($student_id);

// encode the result into JSON Format and send it to the browser
    echo json_encode(array('info' => $info, 'courses' => $courses));
}