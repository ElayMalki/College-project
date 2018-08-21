<?php
session_start();

require_once 'classes/db.php';
require_once 'classes/Auth.php';
require_once 'classes/Student.php';
require_once 'classes/Course.php';

$auth = new Auth();
if( $auth->isLogin() === false ){
    // if not logged in - redirect to login page
    header('location:login.php');
    exit;
}


$title = "School";
include 'views/header.php';

$db = new db();
$students = Student::getAll( $db );

$courses = Course::getAll($db);
?>


<div class="row main-container">
    <div class="col-sm-12 col-md-6">
        <div class="row">
            <div class="col-sm-12 col-md-6 student-cards">
                <h2>
                    Students&nbsp;
                    <?php if( $auth->getRole() !== 3 ) { ?>
                        <a href="#" class="add_student_btn"><i class="fas fa-plus"></i></a>
                    <?php
                    }
                    ?>
                </h2>
                <?php
                foreach( $students as $student ) { ?>
                    <div class="card" id="card-student-<?php echo $student['id'];?>">
                        <div class="card-body display-student" data-id="<?php echo $student['id'];?>">
                            <span id="card_student_name_<?php echo $student['id']; ?>">
                                <?php echo $student['name']; ?>
                            </span>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="col-sm-12 col-md-6 course-cards">
                <h2>
                    Courses&nbsp;
                    <?php if( $auth->getRole() !== 3 ) { ?>
                    <a href="#" class="add_course_btn"><i class="fas fa-plus"></i></a>
                        <?php
                    }
                    ?>
                </h2>
                <?php
                foreach( $courses as $course ) { ?>
                    <div class="card display-course" data-id="<?php echo $course['id'];?>" id="card-course-<?php echo $course['id'];?>">
                        <div class="card-body">
                            <img src="images/courses/<?php echo $course['image_link']; ?>" alt="" id="card_course_image_<?php echo $course['id']; ?>" width="100px">
                            <span id="card_course_name_<?php echo $course['id']; ?>">
                                <?php echo $course['name']; ?>
                            </span>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="main-content statics-text">
            <div class="callout">
                There are <?php echo count( $courses );?> Courses
            </div>
            <div>
                There are <?php echo count( $students );?> Students
            </div>
        </div>

        <div class="student-info">
            <h2>Student info</h2>
            <div>
                <strong>Name:</strong>
                <span class="student_name"></span>
            </div>
            <div>
                <strong>Phone:</strong>
                <span class="student_phone"></span>
            </div>
            <div>
                <strong>Email:</strong>
                <span class="student_email"></span>
            </div>
            <div>
                <ul class="student_courses">

                </ul>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <button class="btn btn-primary edit-student">EDIT</button>
                </div>
                <div class="col-sm-6 text-left">
                    <button class="btn btn-danger" data-student-id="" data-toggle="modal" data-target="#confirm_delete_student_modal">DELETE</button>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" role="dialog" id="confirm_delete_student_modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Are you sure you want to delete?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                            <button type="button" class="btn btn-primary delete-student-btn" data-dismiss="modal">DELETE</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
        <div class="student-edit">
            <h2>Edit Student</h2>
            <form>
                <div class="form-group">
                    <label for="form_edit_student_name">Name</label>
                    <input type="text" class="form-control form_edit_student_name" id="form_edit_student_name" value="">
                </div>
                <div class="form-group">
                    <label for="form_edit_student_phone">Phone</label>
                    <input type="tel" class="form-control form_edit_student_phone" id="form_edit_student_phone" value="">
                </div>
                <div class="form-group">
                    <label for="form_edit_student_email">Email address</label>
                    <input type="email" class="form-control form_edit_student_email" id="form_edit_student_email" value="">
                </div>
                <div class="form-group form_student_courses">
                    <?php
                    foreach( $courses as $course ) {
                        $checked = "";
                        ?>
                        <div>
                            <input type="checkbox" name="form_edit_student_courses[]" class="form_edit_course_checkbox_<?php echo $course['id'];?>" value="<?php echo $course['id'];?>" data-name="<?php echo $course['name']?>" /> <?php echo $course['name']?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <input type="hidden" name="form_edit_student_id" class="form_edit_student_id" value="">
                <button type="submit" class="btn btn-primary update-student">UPDATE</button>
            </form>
        </div>
        <div class="student-add">
            <h2>Add Student</h2>
            <form>
                <div class="form-group">
                    <label for="form_add_student_name">Name</label>
                    <input type="text" class="form-control form_add_student_name" id="form_add_student_name" value="">
                </div>
                <div class="form-group">
                    <label for="form_add_student_phone">Phone</label>
                    <input type="tel" class="form-control form_add_student_phone" id="form_add_student_phone" value="">
                </div>
                <div class="form-group">
                    <label for="form_add_student_email">Email address</label>
                    <input type="email" class="form-control form_add_student_email" id="form_add_student_email" value="">
                </div>
                <button type="submit" class="btn btn-primary add-student">ADD</button>
            </form>
        </div>

        <div class="course-info">
            <h2>Course info</h2>
            <div>
                <strong>Name:</strong>
                <span class="course_name"></span>
            </div>
            <div>
                <strong>Description:</strong>
                <span class="course_description"></span>
            </div>
            <div class="course_image">
                <img src="" alt="" style="max-width: 100%;">
            </div>
            <div>
                <ul class="course_students">

                </ul>
            </div>
            <?php
            if( $auth->getRole() !== 3 ) {
                ?>
                <div class="col-sm-6">
                    <button class="btn btn-primary edit-course">EDIT</button>
                </div>
                <div class="col-sm-6 text-left">
                    <button class="btn btn-danger delete_course" data-course-id="" data-toggle="modal" data-target="#confirm_delete_course_modal">DELETE</button>
                </div>
                <?php
            }
            ?>
            <div class="modal fade" tabindex="-1" role="dialog" id="confirm_delete_course_modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Are you sure you want to delete?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                            <button type="button" class="btn btn-primary delete-course-btn" data-dismiss="modal">DELETE</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
        <?php
        if( $auth->getRole() !== 3 ) {
        ?>
        <div class="course-edit">
            <h2>Edit Course</h2>
            <form>
                <div class="form-group">
                    <label for="form_edit_course_name">Name</label>
                    <input type="text" class="form-control form_edit_course_name" id="form_edit_course_name" value="">
                </div>
                <div class="form-group">
                    <label for="form_edit_course_description">Description</label>
                    <textarea class="form-control form_edit_course_description" id="form_edit_course_description"></textarea>
                </div>
                <div class="form-group">
                    <label for="form_edit_course_image">Upload Image </label>
                    <input type="file" class="form-control form_edit_course_image" id="form_edit_course_image" value="">
                    <span class="form_edit_course_image_text"></span>
                </div>
                <input type="hidden" name="form_edit_course_id" class="form_edit_course_id" value="">
                <button type="submit" class="btn btn-primary update-course">UPDATE</button>
            </form>
        </div>
        <div class="course-add">
            <h2>Add Course</h2>
            <form id="add_course_form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="form_add_course_name">Name</label>
                    <input type="text" class="form-control form_add_course_name" id="form_add_course_name" value="">
                </div>
                <div class="form-group">
                    <label for="form_add_course_description">Description</label>
                    <textarea class="form-control form_add_course_description" id="form_add_course_description"></textarea>
                </div>
                <div class="form-group">
                    <label for="form_add_course_image">Upload Image </label>
                    <input type="file" class="form-control form_add_course_image" id="form_add_course_image" value="">
                </div>
                <button type="submit" class="btn btn-primary add-course">ADD</button>
            </form>
        </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
include 'views/footer.php';
?>
