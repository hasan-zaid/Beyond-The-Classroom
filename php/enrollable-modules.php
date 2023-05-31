<?php 
    $con = new mysqli('localhost', 'root', '', 'fwdd');

    if($con->connect_error)
    {
        echo "Connection to the database has failed !!";
    }

    $stmt = null;

    if(isset($_GET['enrollableModules'])) {
        $studentID = $_GET['id'];
        $query = "SELECT * FROM modules m WHERE m.module_status = 1 AND m.module_id NOT IN (
            SELECT me.module_id FROM module_enrollment me WHERE me.stud_id = ?
        )";
        $stmt = $con->prepare($query);

        if($stmt) {
            $stmt->bind_param("i", $studentID);

            if($stmt->execute()){
                $result = $stmt->get_result();
                $data = array();
    
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                            $data[] = $row;
                    }            
                    echo json_encode($data);
                }
                 else {
                    echo json_encode(array("message" => "No results found"));
                }
            } else {
                echo json_encode(array("message" => "Error executing statement: " . $stmt->error));
            }
    
            $stmt->close();
        } else {
            echo json_encode(array("message" => "Error preparing statement: " . $con->error));
        }
    }

    if(isset($_GET['listModules'])) {
        $query = "SELECT * FROM modules m WHERE m.module_status = ?";
        $stmt = $con->prepare($query);

        if($stmt) {
            $moduleStatus = 1;
            $stmt->bind_param("i", $moduleStatus);

            if($stmt->execute()){
                $result = $stmt->get_result();
                $data = array();
    
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                            $data[] = $row;
                    }            
                    echo json_encode($data);
                }
                 else {
                    echo json_encode(array("message" => "No results found"));
                }
            } else {
                echo json_encode(array("message" => "Error executing statement: " . $stmt->error));
            }
    
            $stmt->close();
        } else {
            echo json_encode(array("message" => "Error preparing statement: " . $con->error));
        }
    }

    if(isset($_POST['enrollToModule'])) {
        $studentID = $_POST['student_id'];
        $moduleID = $_POST['module_id'];
        $enrollmentDate = $_POST['date'];
        $query = "INSERT INTO module_enrollment (stud_id, module_id, enroll_date) VALUES (?, ?, ?)";
        $stmt = $con->prepare($query);

        if($stmt) {
            $stmt->bind_param("iis", $studentID, $moduleID, $enrollmentDate);

            if($stmt->execute()){
                echo json_encode(array("message" => "You have successfully enrolled into the module"));
            } else {
                echo json_encode(array("message" => "Error enrolling to module"));
            }
    
            $stmt->close();
        } else {
            echo json_encode(array("message" => "Error preparing statement: " . $con->error));
        }
    }
?>