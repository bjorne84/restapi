/*
$num = $result->rowCount();

// kolla om det finns data 
if ($num > 0) {
    $course_arr = array();
    $course_arr['data'] = array();

    while ($row = $result->fetch) {
        extract($row);
        $course_item = array(
            'Course_ID' => $id,
            'Course_name' => $course_name,
            'Code' => $code,
            'Progression' => $progression,
            'Course_syllabus' => $kursplan
        );

        // Flytta till data
        array_push($course_arr['data'], $course_item);
    }

    // Gör om till JSON och publicera
    echo json_encode($course_arr);
} else {
    // Ingen data finns

    echo json_encode(
        array('message' => 'Ingen data finns tillgänlig')
    );
}
