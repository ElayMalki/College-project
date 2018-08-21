<?php
session_start();

require_once 'classes/Auth.php';

$auth = new Auth();
$auth->logout();
header('location:home');
exit;
