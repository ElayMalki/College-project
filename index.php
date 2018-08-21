<?php
session_start();

require_once 'classes/db.php';
require_once 'classes/Auth.php';

$auth = new Auth();
if( $auth->isLogin() === true ){
    header('location:school');
    exit;
}


$db = new db();


$message = null;
extract( $_POST );//
// check if the form was submitted
if( isset( $btn_login )) {
    if ( $auth->login( $db, $email, $password ) ) {
        header('location:school');
    } else {
        $message = "Email or password are not correct";
    }
}



$title = "Login";
// include 'views/header.php';

?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="css/style.css">
        <title>College | <?php echo $title; ?></title>
    </head>
    <body>
        
        <div class="row vertical-offset-100">
            <div class="col-xs-6 col-xs-offset-3 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please sign in</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        if( !empty( $message )) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php
                        }
                        ?>
                        <form action="index.php" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input class="form-control" placeholder="E-mail" type="email" id="email" name="email" >
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" placeholder="Password" type="password" id="password" name="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me"> Remember Me
                                    </label>
                                </div>
                                <input class="btn btn-lg btn-block" type="submit" value="Login" id="btn-login" name="btn_login">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php
include 'views/footer.php';
?>
