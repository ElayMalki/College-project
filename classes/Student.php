<?php

class Student {

    public $db;

    public function __construct( $_db ){
        $this->db = $_db;
    }

    public static function getAll( $db ) {

        $sth = $db->pdo->prepare( "SELECT * FROM `students`" );
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }

    public function create( $data ) {
        $sth = $this->db->pdo->prepare( "INSERT INTO `students` (`name`, `phone`, `email`) VALUES( :name, :phone, :email )" );
        $sth->bindParam( ':name', $data['name'] );
        $sth->bindParam( ':phone', $data['phone'] );
        $sth->bindParam( ':email', $data['email'] );
        $sth->execute();
        return $this->db->pdo->lastInsertId();
    }

    public function get_by_id( $id ) {

        $sth = $this->db->pdo->prepare( "SELECT * FROM `students` WHERE `id`=:id" );
        $sth->bindParam( ':id', $id );
        $sth->execute();
        $result = $sth->fetch();
        return $result;
        
    }

    public function update( $id, $data ) {

        $sth = $this->db->pdo->prepare( "UPDATE `students` SET `name`=:name, `phone`=:phone, `email`=:email WHERE `id`=:id" );
        $sth->bindParam( ':name', $data['name'] );
        $sth->bindParam( ':phone', $data['phone'] );
        $sth->bindParam( ':email', $data['email'] );
        $sth->bindParam( ':id', $id );
        $sth->execute();
    }



    public function delete( $id ) {
        $sth = $this->db->pdo->prepare( "DELETE FROM `students` WHERE `id`=:id" );
        $sth->bindParam( ':id', $id );
        $sth->execute();
    }

    public function updateCourses( $student_id, $courses ) {
        $sql = "INSERT INTO `enrollment` (`student_id`, `course_id`) VALUES( :s_id, :c_id )";
        $sth = $this->db->pdo->prepare( $sql );
        foreach ($courses as $course_id ) {
            $sth->bindParam( ':s_id', $student_id );
            $sth->bindParam( ':c_id', $course_id );
            $sth->execute();
        }
    }

    public function removeCourses( $id ) {
        $sql = "DELETE FROM `enrollment` WHERE `student_id`=:id";
        $sth = $this->db->pdo->prepare( $sql );
        $sth->bindParam( ':id', $id );
        $sth->execute();
    }

    // return all student's courses
    public function courses( $id ){
        $select = "SELECT `courses`.`id`, `courses`.`name` 
                   FROM `courses`
                   LEFT JOIN `enrollment`
                   ON `enrollment`.`course_id` = `courses`.`id`
                   WHERE `enrollment`.`student_id`=:id";
        $sth = $this->db->pdo->prepare($select );
        $sth->bindParam( ':id', $id );
        $sth->execute();
        $result = $sth->fetchAll( PDO::FETCH_ASSOC );
        return $result;
    }

}