<?php
    $con = new mysqli('localhost', 'root', '', 'fwdd');

    if($con->connect_error)
    {
        echo "Connection to the database has failed !!";
    }

    $query = '';

    if(isset($_GET['students'])) {
        $query = "SELECT stud_id AS id, stud_name AS name, stud_email AS email, stud_status AS status FROM students";
    }

    elseif(isset($_GET['tutors'])) {
        $query = "SELECT tutor_id AS id, tutor_name  AS name, tutor_email AS email, tutor_status AS status FROM tutors";
    }

    elseif(isset($_GET['listModuleStudents'])) {
        $moduleID = $_GET['moduleID'];
        $query = "SELECT students.stud_id AS id, students.stud_name AS name FROM students JOIN module_enrollment ON students.stud_id = module_enrollment.stud_id WHERE module_enrollment.module_id = '$moduleID';";
    }

    $result = $con->query($query);
    $users = [];
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode($users);
?>