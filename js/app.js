var selected_admin_id = 0;
var selected_student_id = 0;
var selected_course_id = 0;

// display add student form
$('.add_student_btn').on('click', function( event ) {
    event.preventDefault();
    $('.main-content').hide(100);
    $('.student-info').hide(100);
    $('.student-edit').hide(100);
    $('.course-info').hide(100);
    $('.course-edit').hide(100);
    $('.course-add').hide(100);

    $('.student-add').show(800);
});

// display add course form
$('.add_course_btn').on('click', function( event ) {
    event.preventDefault();
    $('.main-content').hide(100);
    $('.student-info').hide(100);
    $('.student-edit').hide(100);
    $('.course-info').hide(100);
    $('.course-edit').hide(100);
    $('.student-add').hide(100);

    $('.course-add').show(800);
});


// display student info
$(document).on( 'click', '.display-student' , function( event ) {
    var stu_id = $(this).data('id');
    // hide the student info box
    $('.main-content').hide(100);
    $('.student-info').hide(100);
    $('.student-edit').hide(100);
    $('.course-info').hide(100);
    $('.course-edit').hide(100);
    $('.student-add').hide(100);
    $('.course-add').hide(800);

    $('input[type="checkbox"]').attr( 'checked', false );
    $('.student_courses').empty();
    // get the student's info from the server
    $.ajax({
        url: "ajax/get_student_data.php",
        type: "POST",
        data : { student_id: stu_id },
        dataType: 'json',
    }).done(function( data ) {
        $('.student_name').html( data.info.name );
        $('.student_phone').html( data.info.phone );
        $('.student_email').html( data.info.email );
        $('.delete-student-btn').attr( 'data-student-id', data.info.id );
        selected_student_id = data.info.id;

        // fill the form inputs
        $('.form_edit_student_name').val( data.info.name );
        $('.form_edit_student_phone').val( data.info.phone );
        $('.form_edit_student_email').val( data.info.email );
        $('.form_edit_student_id').val( data.info.id );
        //$('.student-info').css( 'display', 'block' );
        // show the student info box
        if( data.courses.length > 0 ){
            $.each( data.courses, function( key, course ) {
                $('.student_courses').append( '<li>' + course.name + '</li>');
                $( '.form_edit_course_checkbox_' + course.id ).attr( 'checked', true );
            });
        } else {
            $('.student_courses').append( '<p>No courses for this student</p>');
        }
        $('.student-info').show(500);
    });
});

$('.add-student').on('click', function( event ){
    event.preventDefault();
    var student_name = $('.form_add_student_name').val();
    var student_email = $('.form_add_student_email').val();
    var student_phone = $('.form_add_student_phone').val();
    $.ajax({
        url: "ajax/add_student.php",
        type: "POST",
        data : { student_name: student_name, student_email: student_email, student_phone : student_phone },
        dataType: 'json',
    }).done(function( data ) {
        var html = '<div class="card">' +
            '<div class="card-body display-student" data-id="'+ data.student_id + '">' +
            '<span id="card_student_name_' + data.student_id + '">' +
            student_name +
            '</span>' +
            '</div>' +
            '</div>';
        $('.student-cards').append( html );
        //$('.student-cards').append();
    });
});

$('.edit-student').on('click', function(){
    $('.student-info').hide(100);
    $('.student-edit').show(500);
});

$('.update-student').on('click', function( event ){
    event.preventDefault();
    var student_name = $('.form_edit_student_name').val();
    var student_email = $('.form_edit_student_email').val();
    var student_phone = $('.form_edit_student_phone').val();
    var student_id = selected_student_id;
    var courses_checked = [];
    var courses_checked_names = [];

    $('.student_courses').empty();
    $.each($("input[name='form_edit_student_courses[]']:checked"), function() {
        courses_checked.push( $(this).val() );
        courses_checked_names.push( $(this).data('name') );
    });

    $.ajax({
        url: "ajax/update_student_data.php",
        type: "POST",
        data : { student_name: student_name,
                 student_email: student_email,
                 student_phone : student_phone,
                 student_id: student_id,
                 courses_checked: courses_checked
        },
        dataType: 'json',
    }).done(function( data ) {
        for( var i = 0; i < courses_checked_names.length; i++ ) {
            $('.student_name').html( student_name );
            $('.student_phone').html( student_phone );
            $('.student_email').html( student_email );
            $('.student_courses').append('<li>' + courses_checked_names[i] + '</li>');
            $('.student-edit').hide(100);
            $('.student-info').show(500);
        }
        $('#card_student_name_' + student_id).html( student_name );
    });
});

$('.delete-student-btn').on('click', function( event ){
    var student_id = selected_student_id;
    $.ajax({
        url: "ajax/delete_student.php",
        type: "POST",
        data: {student_id: student_id},
        dataType: 'json',
    }).done(function (data) {
        if( data.status === 'ok' ) {
            var selector = '#card-student-' + student_id;
            $(selector).remove();
            $('.student-info').hide(100);
        } else {
            alert( "you don't have permission to delete students" );
        }
    });
});


// display course info
$( document ).on( 'click', '.display-course', function( event ) {
    var course_id = $(this).data('id');
    // hide the student info box
    $('.main-content').hide(100);
    $('.student-info').hide(100);
    $('.student-edit').hide(100);
    $('.course-info').hide(100);
    $('.course-edit').hide(100);
    $('.student-add').hide(100);
    $('.course-add').hide(800);
    $('.course_students').empty();
    // get the student's info from the server
    $.ajax({
        url: "ajax/get_course_data.php",
        type: "POST",
        data : { course_id: course_id },
        dataType: 'json',
    }).done(function( data ) {
        $('.course_name').html( data.info.name );
        $('.course_description').html( data.info.description );
        $('.course_image img').attr( 'src', 'images/courses/' + data.info.image_link );
        $('.delete-course-btn').attr( 'data-course-id', course_id);
        selected_course_id = course_id;
        //$('.course_image img').attr( 'id', data.image_link );


        $('.form_edit_course_name').val( data.info.name );
        $('.form_edit_course_description').val( data.info.description );
        $('.form_edit_course_id').val( data.info.id );
        $('.form_edit_course_image_text').html( data.info.image_link );

        if( data.students.length > 0 ){
            $.each( data.students, function( key, student ) {
                $('.delete_course').prop('disabled', true);
                $('.course_students').append( '<li>' + student.name + '</li>');
            });
        } else {
            $('.delete_course').prop('disabled', false);
            $('.course_students').append( '<p>No courses for this student</p>');
        }

        $('.course-info').show(500);
    });
});


$('.add-course').on('click', function( event ){
    event.preventDefault();
    var course_name = $('.form_add_course_name').val();
    var course_description = $('.form_add_course_description').val();
    var course_image = $('#form_add_course_image').get(0).files[0];

    var formData = new FormData();
    formData.append('course_name', course_name);
    formData.append('course_description', course_description);
    formData.append('course_image', course_image);

    //console.log(course_image);
    $.ajax({
        url: "ajax/add_course.php",
        type: "POST",
        data : formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false
    }).done(function( data ) {
        var html = '<div class="card display-course">' +
            '<div class="card-body display-course" data-id="'+ data.course_id + '">' +
            '<img src="images/courses/' + data.image_link + '" alt="" width="100px">' +
            '<span id="card_course_name_' + data.course_id + '">' +
            course_name +
            '</span>' +
            '</div>' +
            '</div>';
        $('.course-cards').append( html );
    });
});

$('.edit-course').on('click', function(){
    $('.course-info').hide(100);
    $('.course-edit').show(500);
});


$('.update-course').on('click', function( event ){
    event.preventDefault();
    var course_name = $('.form_edit_course_name').val();
    var course_description = $('.form_edit_course_description').val();
    var course_image = $('#form_edit_course_image').get(0).files[0];
    var course_id = $('.form_edit_course_id').val();

    var formData = new FormData();
    formData.append('course_name', course_name);
    formData.append('course_description', course_description);
    formData.append('course_image', course_image);
    formData.append('course_id', course_id);

    //console.log(course_image);
    $.ajax({
        url: "ajax/update_course.php",
        type: "POST",
        data : formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false
    }).done(function( data ) {
        $('#card_course_name_' + course_id).html( course_name );
        $('#card_course_image_' + course_id).attr( 'src', 'images/courses/' + data.image_link );
        $('.course_image img').attr( 'src', 'images/courses/' + data.image_link );
        $('.course-edit').hide(100);
        $('.course-info').show(500);
    });
});

$('.delete-course-btn').on('click', function( event ){
    var course_id = selected_course_id;
    $.ajax({
        url: "ajax/delete_course.php",
        type: "POST",
        data: {course_id: course_id},
        dataType: 'json',
    }).done(function (data) {
        if( data.status === 'ok' ) {
            var selector = '#card-course-' + course_id;
            $(selector).remove();
            $('.course-info').hide(100);
        } else {
            alert( "you don't have permission to delete courses" );
        }
    });
});

/* ADMIN ACTIONS */
// display admins info
$(document).on( 'click', '.display-admin' , function( event ) {
    var admin_id = $(this).data('id');
    $('.main-content').hide(100);
    $('.admin-info').hide(100);
    $('.admin-edit').hide(100);
    $('.admin-add').hide(100);
    $('.update_alert').html( '' );
    // get the student's info from the server
    $.ajax({
        url: "ajax/get_admin_data.php",
        type: "POST",
        data : { admin_id: admin_id },
        dataType: 'json',
    }).done(function( data ) {
        $('.admin_name').html( data.name );
        $('.admin_phone').html( data.phone );
        $('.admin_email').html( data.email );
        $('.admin_image img').attr( 'src', 'images/admins/' + data.image_link );
        if( data.role_id == 1 ){
            $('.delete_admin_wrapper').hide(1);
        } else {
            $('.delete_admin_wrapper').show(1);
        }

        // fill the form inputs
        $('.form_edit_admin_name').val( data.name );
        $('.form_edit_admin_phone').val( data.phone );
        $('.form_edit_admin_email').val( data.email );
        $('.form_edit_admin_image_text').html( data.image_link );
        $('.delete-admin-btn').attr( 'data-admin-id', admin_id);
        $('.delete_admin').attr( 'data-admin-id', admin_id);
        selected_admin_id = admin_id;
        /*if( $(window).width() < 768  ){
            $(".admin-info").detach().appendTo("#display-admin_"+admin_id);
        } else {
            $(".admin-info").detach().appendTo(".admins-area");
        }*/

        $('.form_edit_admin_id').val( data.id );
        $('.admin-info').show(500);
    });
});

$('.add_admin_btn').on('click', function( event ) {
    event.preventDefault();
    $('.main-content').hide(100);
    $('.admin-info').hide(100);
    $('.admin-edit').hide(100);
    $('.admin-add').show(800);
});


$('.add-admin').on('click', function( event ){
    event.preventDefault();
    var admin_name = $('.form_add_admin_name').val();
    var admin_phone = $('.form_add_admin_phone').val();
    var admin_email = $('.form_add_admin_email').val();
    var admin_password = $('.form_add_admin_password').val();
    var admin_role_id = $('.form_add_admin_role_id').val();
    var admin_image = $('#form_add_admin_image').get(0).files[0];

    var formData = new FormData();
    formData.append('admin_name', admin_name);
    formData.append('admin_phone', admin_phone);
    formData.append('admin_email', admin_email);
    formData.append('admin_password', admin_password);
    formData.append('admin_role_id', admin_role_id);
    formData.append('admin_image', admin_image);

    //console.log(admin_image);
    $.ajax({
        url: "ajax/add_admin.php",
        type: "POST",
        data : formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false
    }).done(function( data ) {
        var html = '<div class="card display-admin">' +
            '<div class="card-body display-admin" data-id="'+ data.admin_id + '">' +
            '<img src="images/admins/' + data.image_link + '" alt="" width="100px">' +
            '<span id="card_admin_name_' + data.admin_id + '">' +
            admin_name +
            '</span>' +
            '</div>' +
            '</div>';
        $('.admin-cards').append( html );
    });
});

$('.edit-admin').on('click', function(){
    $('.admin-info').hide(100);
    $('.admin-edit').show(500);
});


$('.update-admin').on('click', function( event ){
    event.preventDefault();
    var admin_name = $('.form_edit_admin_name').val();
    var admin_phone = $('.form_edit_admin_phone').val();
    var admin_email = $('.form_edit_admin_email').val();
    var admin_password = $('.form_edit_admin_password').val();
    var admin_image = $('#form_edit_admin_image').get(0).files[0];
    var admin_id = $('.form_edit_admin_id').val();

    var formData = new FormData();
    formData.append('admin_name', admin_name);
    formData.append('admin_phone', admin_phone);
    formData.append('admin_email', admin_email);
    formData.append('admin_password', admin_password);
    formData.append('admin_image', admin_image);
    formData.append('admin_id', admin_id);

    //console.log(admin_image);
    $.ajax({
        url: "ajax/update_admin.php",
        type: "POST",
        data : formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false
    }).done(function( data ) {
        if( data.status === 'ok' ) {
            $('#card_admin_name_' + admin_id).html(admin_name);
            $('#card_admin_image_' + admin_id).attr('src', 'images/admins/' + data.image_link);
            $('.admin_name').html(admin_name);
            $('.admin_phone').html(admin_phone);
            $('.admin_email').html(admin_email);
            $('.admin_image img').attr('src', 'images/admins/' + data.image_link);

            $('.update_alert').html( '' );
            $('.admin-edit').hide(100);
            $('.admin-info').show(500);
        } else {
            $('.update_alert').html( '<span class="alert alert-danger update_alert">You can only update your own info</span>' );
        }
    });
});

$(document).on('click', '.delete-admin-btn', function( event ){
    var admin_id = selected_admin_id;
    $.ajax({
        url: "ajax/delete_admin.php",
        type: "POST",
        data: {admin_id: admin_id},
        dataType: 'json',
    }).done(function (data) {
        if( data.status === 'ok' ) {
            var selector = '#card-admin-' + admin_id;
            $(selector).remove();
            $('.admin-info').hide(100);
        } else {
            alert("Cannot delete owner");
        }
    });
});


/* /ADMIN ACTIONS */
