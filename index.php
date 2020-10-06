<?php
include_once('includes/config.php');
//require('classes/courses.class.php');

/* Inställnignar i header-info: 
1. talar om att det är JSON-data webbtjänsten tillhandahåller
2. Att tjänsten går att komma åt från valrfri domän och inte bara det egna, asterixen* = alla
3. Ställer så att alla HTTP-metoder går att använda, vanligtvis är det bara GET som standard
4. Ställer in så att alla headers används*/
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Origin, Access-Control-Allow-Methods, Authorization, X-Requested-With');

/* Kontrollera vilken HTTP-metod som används och lagra den*/
$HTTP_method = $_SERVER['REQUEST_METHOD'];

/* Kontrollerar om id finns med och sparar det i variabel*/
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

//new Dbc;
$course = new CoursesModel();
$controlCourse = new CoursesContrl();
/* Kollar vilken HTTP-metod som används och startar respektive metod*/
switch ($HTTP_method) {
    case 'GET':
        if (isset($id)) {
            // Startar metod för att läsa ut en enskild kurs
            $result = $course->getPostById($id);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            // Hämtar alla kurser
            $result = $course->getAllPosts();
            echo json_encode($result, JSON_PRETTY_PRINT);
        }

        // Kollar om resultatet innehåller något och skapar HTTP-responsecode
        if(sizeof($result) > 0) {
            http_response_code(200); // 
        } else {
            http_response_code(404); // Not found
            $result = ["message 0" => "Ingenting hittat"];
        }
    break;
    case 'POST':
        $result = $controlCourse->setPost2();
        if($result) {
            //var_dump($result);
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    break;
    case 'PUT':
        $result = $controlCourse->updatePost();
        if($result) {
            //var_dump($result);
            echo json_encode($result, JSON_PRETTY_PRINT);
        }

}
