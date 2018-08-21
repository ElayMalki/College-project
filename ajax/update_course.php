<?php
session_start();

include '../classes/Course.php';
include '../classes/Auth.php';
include '../classes/db.php';

$auth = new Auth();

if( $auth->isLogin() && ( $auth->getRole() === 1 || $auth->getRole() === 2 ) ) {
    $db = new db();
    $file_name = "";
    $course = new Course( $db );
    $course_id = $_POST['course_id'];
    if( !empty($_FILES['course_image']['name'])) {
        $upload_dir = '../images/courses';

        $file_name = time() . "_" . $_FILES['course_image']['name'];
        $file_size = $_FILES['course_image']['size'];
        $file_tmp = $_FILES['course_image']['tmp_name'];
        $file_type = $_FILES['course_image']['type'];
        //$file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));

        $extensions = array("jpeg", "jpg", "png");
        move_uploaded_file( $file_tmp, "$upload_dir/$file_name");
    }



    // get current course data
    $current_course = $course->get_by_id($course_id);
    // if the user update image - delete previous one
    if( strlen( $file_name ) > 0 ) {
        // delete current course's image
        unlink($upload_dir . '/' . $current_course['image_link']);
    } else {
        $file_name = $current_course['image_link'];
    }

    $course_data = array(
        'name' => $_POST['course_name'],
        'description' => $_POST['course_description'],
        'image_link' => $file_name,
        'id' => $course_id
    );
    $course->update( $course_id, $course_data );


    echo json_encode( array( 'status' => "ok", 'course_id' => $course_id, 'image_link' => $file_name  ));
} else {

}

