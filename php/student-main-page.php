<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fwdd";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$con = mysqli_connect($servername, $username, $password, $dbname);



// Check if the request is an AJAX request
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(!isset($_GET['id'])) {
        echo json_encode(['error' => 'User not logged in.']);
        exit();
    }
    $stud_id = $_GET['id'];
        $data = mysqli_query($con, "SELECT * FROM `module_enrollment` WHERE `stud_id` = '" . mysqli_real_escape_string($con, $stud_id) . "'");
        if (!$data) {
            echo json_encode(['error' => "Error in module_enrollment query: " . mysqli_error($con)]);
            exit();
        }

        $module_ids = array();
        while($row = mysqli_fetch_assoc($data)) {
            $module_ids[] = $row['module_id'];
        }

        $modules_data = array();
        foreach($module_ids as $module_id) {
            $module_data = mysqli_query($con, "SELECT modules.*, tutors.tutor_name FROM modules INNER JOIN tutors ON modules.tutor_id = tutors.tutor_id WHERE modules.module_id = '" . mysqli_real_escape_string($con, $module_id) . "';");
            if (!$module_data) {
                echo json_encode(['error' => "Error in modules query: " . mysqli_error($con)]);
                exit();
            }
            while($row = mysqli_fetch_assoc($module_data)) {
                $modules_data[] = $row;
            }
        }

        echo json_encode(['modules' => $modules_data]);

    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['drop-module'])) {
            $module_id_to_drop = $_POST['module_id'];
            if(!isset($_POST['id'])) {
                echo json_encode(['error' => 'User not logged in.']);
                exit();
            }
            $stud_id = $_POST['id'];
            $query = "DELETE FROM `module_enrollment` WHERE `stud_id` = ? AND `module_id` = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $stud_id, $module_id_to_drop);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo json_encode(['message' => "Module dropped successfully."]);
            } else {
                echo json_encode(['error' => "Failed to drop module."]);
            }
        }
    }
}
?>
