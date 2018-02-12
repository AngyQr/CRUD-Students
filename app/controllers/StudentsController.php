<?php

class StudentsController extends Controller{

    public function index(){
        $this->view('index');
    }

    public function list(){
        $con = Database::connect();
        $stmt = $con->prepare('SELECT id, name, lastname, email FROM student');
        $stmt->execute();
        $students = array();
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            array_push( $students, $row );
        }
        $res['students'] = $students;
        echo json_encode($res);
    }

    public function create(){
        $con = Database::connect();
        $stmt = $con->prepare('INSERT INTO student(name, lastname, email) VALUE (:name, :lastname, :email)');
        $res['error'] = $stmt->execute(
            array(
                ':name' => $_POST['name'],
                ':lastname' => $_POST['lastname'],
                ':email' => $_POST['email'],
            )
        );
        echo json_encode($res);
    }

    public function update(){
        $con = Database::connect();
        $stmt = $con->prepare('UPDATE student SET name = :name , lastname = :lastname, email = :email WHERE id = :id');
        $res['error'] = $stmt->execute(
            array(
                ':name' => $_POST['name'],
                ':lastname' => $_POST['lastname'],
                ':email' => $_POST['email'],
                ':id' => $_POST['id']
            )
        );
        echo json_encode($res);
    }

    public function delete(){
        $con = Database::connect();
        $stmt = $con->prepare('DELETE FROM student WHERE id = :id');
        $res['error'] = $stmt->execute(
            array(
                ':id' => $_POST['id']
            )
        );
        echo json_encode($res);
    }

}