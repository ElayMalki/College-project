<?php
session_start();

include '../classes/Course.php';
include '../classes/Auth.php';
include '../classes/db.php';

$auth = new Auth();

if( $auth->isLogin() && ( $auth->getRole() === 1 || $auth->getRole() === 2 ) ) {
    $db = new db();
// get the course id that was sent from the browser
    $course_id = $_POST['course_id'];
    $course_data = array(
        'name' => $_POST['course_name'],
        'description' => $_POST['description'],
        'image_link' => $_POST['course_image_link']
    );

    $course = new Course($db);
    $course->update($course_id, $course_data);
    echo json_encode(array('status' => "ok"));
}