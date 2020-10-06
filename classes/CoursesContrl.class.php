<?php

class CoursesContrl extends CoursesModel
{

    public function setPost()
    {
        // Hämta data från post
        /* file_get_contents, hämtar rå data innan den hamnar i superglobaler som post och get*/
        $inputJSON = file_get_contents('php://input');
        // Från json till php
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        // Sanerera data och lägg array i ny variabel.
        $cData = filter_var_array($input, FILTER_SANITIZE_SPECIAL_CHARS);
        // Kolla att all data är medskickat (alla fält som behövs för en post, not null)

        /* If either of required fields are empty, error array with input-data and message. */
        if (empty($cData['Course_name']) || empty($cData['Code']) || empty($cData['Progression']) || empty($cData['Course_syllabus'])) {
            $errorMsg = ["Message" => "Du måste skicka med all efterfrågad data, kursnamn, kurskod, progression och kursplan"];
            return $errorMsg;
            exit();
        }

        // Controll lenght of input data

        // Course_Name max 70 caracters
        if(mb_strlen($cData['Course_name'])>70) {
            $errorMsg = ["Message" => "Kursnamnet kan max vara 70 tecken långt"];
            return $errorMsg;
            exit();
        }

        // Code always 6 caracters
        if(mb_strlen($cData['Code'])!==6) {
            $errorMsg = ["Message" => "Kurskoden är alltid 6 tecken långt, prova igen!"];
            return $errorMsg;
            exit();
        }

        // Progression just one and allways a letter
        if(mb_strlen($cData['Progression'])!==1) {
            $errorMsg = ["Message" => "Progression är alltid bara en bokstav!"];
            return $errorMsg;
            exit();
        }

         // Course_syllabus max 250 characters 
         if(mb_strlen($cData['Course_syllabus'])>250) {
            $errorMsg = ["Message" => "Länken till kursplanen kan max vara 250 tecken långt"];
            return $errorMsg;
            exit();
        }

        $CourseName = $cData['Course_name'];
        $Code = $cData['Code'];
        $Progression = $cData['Progression'];
        $Course_syllabus = $cData['Course_syllabus'];
        if($this->sendPost($CourseName, $Code, $Progression, $Course_syllabus)) {
            $message = ["Message" => "Kursen sparades i databasen!"];
            return $message;
            exit();
        } 
        else {
            $errorMsg = ["Message" => "Något gick fel när kursen skulle sparas i databasen"];
            return $errorMsg;
            exit();
        }
        //return $cData;
        // Kolla 
    }

    // Skapa post
    public function setPost2() {
         // Hämta data från post
        /* file_get_contents, hämtar rå data innan den hamnar i superglobaler som post och get*/
        $inputJSON = file_get_contents('php://input');
        // Från json till php
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        // Sanerera data och lägg array i ny variabel.
        $cData = filter_var_array($input, FILTER_SANITIZE_SPECIAL_CHARS);
       // var_dump($cData);
        //Kör kontroll-metod för att testa att all data finns med och i rätt format/storlek
        $cData = $this->controlData($cData);
        //var_dump($cData);
        if(!isset($cData['Course_name'])) {
            return $cData;
            exit();
        }
        //Tilldelar variabeler
        $Course_ID = $cData['Course_ID'];
        $CourseName = $cData['Course_name'];
        $Code = $cData['Code'];
        $Progression = $cData['Progression'];
        $Course_syllabus = $cData['Course_syllabus'];
        if($this->sendPost($CourseName, $Code, $Progression, $Course_syllabus)) {
            $message = ["Message" => "Kursen sparades i databasen!"];
            return $message;
            exit();
        } 
        else {
            $errorMsg = ["Message" => "Något gick fel när kursen skulle sparas i databasen"];
            return $errorMsg;
            exit();
        }

    }


    // Uppdatera
    public function updatePost() {
        // Hämta data från post
        /* file_get_contents, hämtar rå data innan den hamnar i superglobaler som post och get*/
        $inputJSON = file_get_contents('php://input');
        // Från json till php
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        // Sanerera data och lägg array i ny variabel.
        $cData = filter_var_array($input, FILTER_SANITIZE_SPECIAL_CHARS);

        //Kör kontroll-metod för att testa att all data finns med och i rätt format/storlek
        $cData = $this->controlData($cData);
        //var_dump($cData);
        if(!isset($cData['Course_name'])) {
            return $cData;
            exit();
        }
        //Tilldelar variabeler
        $Course_ID = $cData['Course_ID'];
        $CourseName = $cData['Course_name'];
        $Code = $cData['Code'];
        $Progression = $cData['Progression'];
        $Course_syllabus = $cData['Course_syllabus'];

        //Kör kontroll enbart för id
        if (is_numeric($Course_ID)) {
            //check lenght
            $lenght = mb_strlen($Course_ID);
            if ($lenght === 4) {
                $this->updateSQL($CourseName, $Code, $Progression, $Course_syllabus,$Course_ID);
                $message = ["Message" => "Kursen uppdaterades med information i databasen!"];
                return $message;
                exit();
            } else {
                $errorMsg = ["Message" => "ID har fyra siffror"];
                return $errorMsg;
                exit();
            }
        }  else {
            $errorMsg = ["Message" => "ID måste skickas med och består endast av siffor!"];
            return $errorMsg;
            exit();
        }   
    }


    // Funktion för att kontrollera indata, både för ny post och uppdateringar
    public function controlData($cData) {
          /* If either of required fields are empty, error array with input-data and message. */
          if (empty($cData['Course_name']) || empty($cData['Code']) || empty($cData['Progression']) || empty($cData['Course_syllabus'])) {
            $errorMsg = ["Message" => "Du måste skicka med all efterfrågad data, kursnamn, kurskod, progression och kursplan"];
            return $errorMsg;
            exit();
        }
        // ----- Controll lenght of input data --------

        // Course_Name max 70 caracters
        if(mb_strlen($cData['Course_name'])>70) {
            $errorMsg = ["Message" => "Kursnamnet kan max vara 70 tecken långt"];
            return $errorMsg;
            exit();
        }
        // Code always 6 caracters
        if(mb_strlen($cData['Code'])!==6) {
            $errorMsg = ["Message" => "Kurskoden är alltid 6 tecken långt, prova igen!"];
            return $errorMsg;
            exit();
        }
        // Progression just one and allways a letter
        if(mb_strlen($cData['Progression'])!==1) {
            $errorMsg = ["Message" => "Progression är alltid bara en bokstav!"];
            return $errorMsg;
            exit();
        }
         // Course_syllabus max 250 characters 
         if(mb_strlen($cData['Course_syllabus'])>250) {
            $errorMsg = ["Message" => "Länken till kursplanen kan max vara 250 tecken långt"];
            return $errorMsg;
            exit();
        }
        return $cData;
    }

    // Uppdatera kurs







}