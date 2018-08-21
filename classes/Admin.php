<?php

class Admin {

    public $db;

    public function __construct( $_db ){
        $this->db = $_db;
    }

    public static function getAll( $db, $role_id ) {
        $sth = $db->pdo->prepare( "SELECT * FROM `admins` WHERE role_id>=:role_id" );
        $sth->bindParam( ':role_id', $role_id );
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }


    public function create( $data ) {
        $sth = $this->db->pdo->prepare( "INSERT INTO `admins` (`name`, `password`, `email`, `phone`, `image_link`, `role_id` ) VALUES( :name, :password, :email, :phone, :image_link, :role_id )" );
        $sth->bindParam( ':name', $data['name'] );
        $sth->bindParam( ':password', $data['password'] );
        $sth->bindParam( ':email', $data['email'] );
        $sth->bindParam( ':phone', $data['phone'] );
        $sth->bindParam( ':image_link', $data['image_link'] );
        $sth->bindParam( ':role_id', $data['role_id'] );
        $sth->execute();
        return $this->db->pdo->lastInsertId();
    }

    public function get( $admin_id ) {
        $sql = "SELECT `admins`.*, `roles`.role
                FROM `admins` LEFT JOIN `roles`
                ON `admins`.`role_id` = `roles`.`id`
                WHERE `admins`.id=:admin_id";
        $sth = $this->db->pdo->prepare( $sql );
        $sth->bindParam( ':admin_id', $admin_id );
        $sth->execute();
        $result = $sth->fetch();
        return $result;
    }

    public function update( $id, $data ) {

        if( $data['image_link'] !== false ) {

            if( strlen( $data['password'] ) > 0 ) {
                $sql = "UPDATE `admins` SET `name`=:name, `phone`=:phone, `email`=:email, `password`=:pass, `image_link`=:image_link WHERE `id`=:id";
                $sth = $this->db->pdo->prepare($sql);
            } else {
                $sql = "UPDATE `admins` SET `name`=:name, `phone`=:phone, `email`=:email, `image_link`=:image_link WHERE `id`=:id";
                $sth = $this->db->pdo->prepare($sql);
            }
        } else {
            if( strlen( $data['password'] ) > 0 ) {
                $sql =  "UPDATE `admins` SET `name`=:name, `phone`=:phone, `email`=:email, `password`=:pass WHERE `id`=:id";
                $sth = $this->db->pdo->prepare($sql);
            } else {
                $sql = "UPDATE `admins` SET `name`=:name, `phone`=:phone, `email`=:email WHERE `id`=:id";
                $sth = $this->db->pdo->prepare($sql);
            }
        }

        //$sql = "UPDATE `admins` SET `name`=:name, `phone`=:phone WHERE `id`=:id";
        //$sth = $this->db->pdo->prepare($sql);

        $sth->bindParam( ':name', $data['name'] );
        $sth->bindParam( ':phone', $data['phone'] );
        $sth->bindParam( ':email', $data['email'] );
        if( strlen($data['password']) > 0 ) {
            $sth->bindParam(':pass', $data['password'] );
        }
        if( $data['image_link'] !== false ) {
            $sth->bindParam(':image_link', $data['image_link']);
        }
        $sth->bindParam( ':id', $id );
        $sth->execute();

        return $sql;
    }

    public function delete( $id ) {
        $sth = $this->db->pdo->prepare( "DELETE FROM `admins` WHERE `id`=:id" );
        $sth->bindParam( ':id', $id );
        $sth->execute();
    }



}