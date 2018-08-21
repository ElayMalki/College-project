<?php

class Course {

    public $db;

    public function __construct( $_db ){
        $this->db = $_db;
    }

    public static function getAll( $db ) {

        $sth = $db->pdo->prepare( "SELECT * FROM `courses`" );
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }

    public function create( $data ) {
        $sth = $this->db->pdo->prepare( "INSERT INTO `courses` (`name`, `description`, `image_link`) VALUES(:name, :description, :image_link)" );
        $sth->bindParam( ':name', $data['name'] );
        $sth->bindParam( ':description', $data['description'] );
        $sth->bindParam( ':image_link', $data['image_link'] );
        $sth->execute();
        return $this->db->pdo->lastInsertId();
    }

    public function get_by_id( $id ) {
        $sth = $this->db->pdo->prepare( "SELECT * FROM `courses` WHERE `id`=:id" );
        $sth->bindParam( ':id', $id );
        $sth->execute();
        $result = $sth->fetch();
        return $result;

    }

    public function update( $id, $data ) {
        $sth = $this->db->pdo->prepare( "UPDATE `courses` SET `name`=:name, `description`=:description, `image_link`=:image_link WHERE `id`=:id" );
        $sth->bindParam( ':name', $data['name'] );
        $sth->bindParam( ':description', $data['description'] );
        $sth->bindParam( ':image_link', $data['image_link'] );
        $sth->bindParam( ':id', $id );
        $sth->execute();
    }

    public function delete( $id ) {
        $sth = $this->db->pdo->prepare( "DELETE FROM `courses` WHERE `id`=:id" );
        $sth->bindParam( ':id', $id );
        $sth->execute();
    }


    // return all student's courses
    public function students( $id ){
        $select = "SELECT `students`.`id`, `students`.`name` 
                   FROM `students`
                   LEFT JOIN `enrollment`
                   ON `enrollment`.`student_id` = `students`.`id`
                   WHERE `enrollment`.`course_id`=:id";
        $sth = $this->db->pdo->prepare($select );
        $sth->bindParam( ':id', $id );
        $sth->execute();
        $result = $sth->fetchAll( PDO::FETCH_ASSOC );
        return $result;
    }

}