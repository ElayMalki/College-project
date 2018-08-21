<?php
class Auth {

    function isLogin() {
        if( !empty ( $_SESSION['user_id'] ) ){
            return true;
        } else {
            return false;
        }
    }

    function login( $db, $email, $password ) {
        $sth = $db->pdo->prepare( "SELECT * FROM `admins` WHERE `email`=:email LIMIT 1" );
        $sth->bindParam( ':email', $email );
        $sth->execute();
        if( $sth->rowCount() === 1 ) {
            $row = $sth->fetch();
            if( $this->verifyPassword( $password, $row['password'] ) ) {

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role_id'] = $row['role_id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['image_link'] = $row['image_link'];

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    function logout() {
        session_destroy();
    }

    public function getHashPassword( $password ) {
        return password_hash( $password, PASSWORD_DEFAULT );
    }

    public function verifyPassword( $password, $hash_password ){
        return password_verify( $password, $hash_password );
    }


    public function getRole( ) {
        if (!empty($_SESSION['role_id'])) {
            return (int)$_SESSION['role_id'];
        }
        return false;
    }

    public function getId() {
        if( $_SESSION['user_id'] ) {
            return $_SESSION['user_id'];
        }
        return false;
    }


}