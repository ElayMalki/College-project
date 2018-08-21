<?php
session_start();

require_once 'classes/db.php';
require_once 'classes/Auth.php';
require_once 'classes/Admin.php';

$auth = new Auth();
if( $auth->isLogin() === false ){
    // if not logged in - redirect to login page
    header('location:login.php');
    exit;
}
if( $auth->getRole() === 3 ){
    header('location:school.php');
    exit;
}


$title = "Administrators";
include 'views/header.php';

$db = new db();
$admin = new Admin( $db );

$all_admins = Admin::getAll( $db,  $auth->getRole() );
?>
<div class="row">
    <div class="col-sm-12 col-md-6 admin-cards">
        <h2>
            Admins
            <?php if( $auth->getRole() === 1 ) { ?>
                <a href="#" class="add_admin_btn"><i class="fas fa-plus"></i></a>
                <?php
            }
            ?>
        </h2>
        <?php
        foreach( $all_admins as $one_admin ) { ?>
            <div class="card" id="card-admin-<?php echo $one_admin['id']; ?>">
                <div class="card-body display-admin" data-id="<?php echo $one_admin['id'];?>" id="display-admin_<?php echo $one_admin['id'];?>">
                    <img src="images/admins/<?php echo $one_admin['image_link']; ?>" id="card_admin_image_<?php echo $one_admin['id']; ?>" alt="" width="100px">
                    <span id="card_admin_name_<?php echo $one_admin['id']; ?>">
                        <?php echo $one_admin['name']; ?>
                    </span>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <div class="col-sm-12 col-md-6 admins-area">
        <div class="main-content">
            <div class="callout">
                There are <?php echo count( $all_admins );?> Admins
            </div>
        </div>

        <div class="admin-info">
            <h2>Admin info</h2>
            <div>
                <strong>Name:</strong>
                <span class="admin_name"></span>
            </div>
            <div>
                <strong>Phone:</strong>
                <span class="admin_phone"></span>
            </div>
            <div>
                <strong>Email:</strong>
                <span class="admin_email"></span>
            </div>
            <div class="admin_image">
                <img src="" alt="" style="max-width: 100%;">
            </div>
            <div class="col-sm-6">
                <button class="btn btn-primary edit-admin">EDIT</button>
            </div>
            <?php if( $auth->getRole() === 1 ) { ?>
                <div class="col-sm-6 text-left delete_admin_wrapper">
                    <button class="btn btn-danger delete_admin" data-admin-id="" data-toggle="modal"
                            data-target="#confirm_delete_admin_modal">DELETE
                    </button>
                </div>
                <?php
            }
            ?>
            <div class="modal fade" tabindex="-1" role="dialog" id="confirm_delete_admin_modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Are you sure you want to delete?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                            <button type="button" class="btn btn-primary delete-admin-btn" data-dismiss="modal">DELETE</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
        <div class="admin-edit">
            <h2>Edit Admin</h2>
            <form>
                <div class="form-group">
                    <label for="form_edit_admin_name">Name</label>
                    <input type="text" class="form-control form_edit_admin_name" id="form_edit_admin_name" value="">
                </div>
                <div class="form-group">
                    <label for="form_edit_admin_phone">Phone</label>
                    <input type="tel" class="form-control form_edit_admin_phone" id="form_edit_admin_phone" value="">
                </div>
                <div class="form-group">
                    <label for="form_edit_admin_email">Email address</label>
                    <input type="email" class="form-control form_edit_admin_email" id="form_edit_admin_email" value="">
                </div>
                <div class="form-group">
                    <label for="form_edit_admin_password">Password</label>
                    <input type="password" class="form-control form_edit_admin_password" id="form_edit_admin_password" value="">
                </div>
                <div class="form-group">
                    <label for="form_edit_admin_image">Upload Image </label>
                    <input type="file" class="form-control form_edit_admin_image" id="form_edit_admin_image" value="">
                    <span class="form_edit_admin_image_text"></span>
                </div>
                <div class="form-group">
                    <input type="hidden" name="form_edit_admin_id" class="form_edit_admin_id" value="">
                    <button type="submit" class="btn btn-primary update-admin">UPDATE</button>
                </div>
                <div class="form-group">
                    <div class="update_alert">

                    </div>
                </div>
            </form>
        </div>
        <?php if( $auth->getRole() === 1 ) { ?>
            <div class="admin-add">
                <h2>Add Admin</h2>
                <form>
                    <div class="form-group">
                        <label for="form_add_admin_name">Name</label>
                        <input type="text" class="form-control form_add_admin_name" id="form_add_admin_name" value="">
                    </div>
                    <div class="form-group">
                        <label for="form_add_admin_phone">Phone</label>
                        <input type="tel" class="form-control form_add_admin_phone" id="form_add_admin_phone" value="">
                    </div>
                    <div class="form-group">
                        <label for="form_add_admin_email">Email address</label>
                        <input type="email" class="form-control form_add_admin_email" id="form_add_admin_email"
                               value="">
                    </div>
                    <div class="form-group">
                        <label for="form_add_admin_password">Password</label>
                        <input type="password" class="form-control form_add_admin_password" id="form_add_admin_password" value="">
                    </div>
                    <div class="form-group">
                        <label for="form_add_admin_role_id">Role</label>
                        <select name="form_add_admin_role_id" class="form_add_admin_role_id" id="form_add_admin_role_id">
                            <option value="2">Manager</option>
                            <option value="3">Sales</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="form_add_admin_image">Upload Image </label>
                        <input type="file" class="form-control form_add_admin_image" id="form_add_admin_image" value="">
                    </div>
                    <button type="submit" class="btn btn-primary add-admin">ADD</button>
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

