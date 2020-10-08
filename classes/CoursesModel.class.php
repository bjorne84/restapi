<?php

// Ny klass för kurser, ärver databasklassen
class CoursesModel extends Dbc
{

    // Properties
 
    // Konstruktor
    public function __construct()
    {
    }

    // GET data, 
 
    //alla poster
    public function getAllPosts()
    {
        // SQL fråga
        $sql = "SELECT * FROM Courses";
        $result = $this->connect()->query($sql);
        return $result->fetchAll();
        exit();
    }

    // Hämta poster för Enskilt ID
    public function getPostById($id)
    {
        // Sanitize variable
        $id = filter_var($id, FILTER_SANITIZE_STRING);
        //Kollar att variabeln är numrerisk
        if (is_numeric($id)) {
            //check lenght
            $lenght = mb_strlen($id);
            if ($lenght === 4) {
                // SQL-fråga. med preperad statement
                $sql = "SELECT * FROM Courses WHERE Course_ID = ? ";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$id]);
                $result = $stmt->fetch();
                return $result;
                exit();
            } else {
                $result = "ID har fyra siffror";
                return $result;
                exit();
            }
        } else {
            $result = "ID består av endast siffror";
            return $result;
            exit();
        }
    }

    // Skapa ny post i databasen
    public function sendPost($CourseName, $Code, $Progression, $Course_syllabus) {
        $sql = "INSERT INTO Courses (Course_name, Code, Progression ,Course_syllabus) VALUES(?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$CourseName, $Code, $Progression, $Course_syllabus]);
        return true;
    }

    //Uppdatera post i databasen
    public function updateSQL($CourseName, $Code, $Progression, $Course_syllabus, $Course_ID) {
        $sql = "UPDATE Courses
        SET Course_name = ?, Code = ?, Progression = ?, Course_syllabus = ?
    WHERE Course_ID = $Course_ID";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$CourseName, $Code, $Progression, $Course_syllabus]);
    //var_dump($stmt);
    return true;
    }

    // Kontrollerar om ett ID existerar
    public function checkId($Course_ID) {
        $sql = "SELECT Course_ID FROM Courses WHERE Course_ID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$Course_ID]);
        $result = $stmt->fetch();
        return $result;
    }

    // Ta bort post ur databasen
    public function deleteSQL($Course_ID) {
        $sql = "DELETE FROM Courses WHERE Course_ID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$Course_ID]);
        return true;
    }

}
