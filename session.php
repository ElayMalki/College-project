<?php
session_start();
//session_destroy();
if( empty( $_SESSION['counter'] ) ) {
    $_SESSION['counter'] = 1;
} else {
    $_SESSION['counter']++;
}

echo "Counter = ".$_SESSION['counter'];