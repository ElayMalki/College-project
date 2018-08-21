<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">

        <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/0/02/Culcheth_High_School_Logo.png"></link>
        <link href="https://fonts.googleapis.com/css?family=Raleway:200" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0.1"></link>
        <title>College | <?php echo $title; ?></title>
    </head>
    <body>
        <div class="container body-container">
            <div class="row header-container">
                <div class="sm-col-12">
                    <nav class="navbar navbar-default navbar-static-top">
                        <div class="container-fluid">
                            <div class="navbar-header" >
                                <!-- <button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed">
                               MENU
                                </button> -->
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="index.php">
                                    The School
                                </a>
                            </div>
                            <div class="tab">
                                <ul class="nav navbar-nav">
                                    <li><a href="school"><span class="glyphicon glyphicon-th"></span> School</a></li>
                                    <?php if( $auth->getRole() !== 3 ) { ?>
                                        <li><a href="administrator"><span class="glyphicon glyphicon-user"></span>
                                                Administrator</a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav navbar-right">
                                    <li>
                                        <span class="user-role dropdown-toggle"></span>
                                    </li>
                                    <li class="dropdown ">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                            <?php
                                            if( !empty( $_SESSION['image_link'] )) { ?>
                                                <img src="images/admins/<?php echo $_SESSION['image_link']; ?>" alt="" height="50px">
                                                <?php
                                            }
                                            ?>
                                            Hello
                                            <?php
                                            if( !empty( $_SESSION['name'] )) {
                                                echo $_SESSION['name'];
                                            }
                                            ?><span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class="dropdown-header"></li>
                                            <li><a href="logout">Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>



