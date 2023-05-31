<?php 
    $con = new mysqli('localhost', 'root', '', 'fwdd');

    if($con->connect_error)
    {
        echo "Connection to the database has failed !!";
    }

    $query = "";
    $stmt = null;

    if(isset($_GET['Fetchassessment'])){
        $moduleID = $_GET['module_id'];
        $assessID = "SELECT assessment_id FROM assessments WHERE module_id = $moduleID";
        $res = $con->query($assessID);
        $assessment_id = 0;
        while($row = $res->fetch_assoc()){
            $assessment_id = $row['assessment_id'];
        } 
        $query = "SELECT * FROM questions WHERE assessment_id = ?";
        $stmt = $con->prepare($query);

        if($stmt) {
            $stmt->bind_param("i", $assessment_id);

            if($stmt->execute()){
                $result = $stmt->get_result();
    
                if($result->num_rows > 0){
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    echo json_encode($data);        
                } else {
                    echo json_encode(array("message" => "There is no assessment for this module."));
                }
            } else {
                echo json_encode(array("message" => "Error fetching assessment questions"));
            }

            $stmt->close();
        } else {
            echo json_encode(array("message" => "Error in SQL query"));
        }
    }

    if(isset($_POST['assessmentComplete'])) {
        $student_id = $_POST['student_id'];
        $moduleID = $_POST['module_id'];
        $score = $_POST['score'];
        $completionDate = $_POST['date'];

        $assessID = "SELECT assessment_id FROM assessments WHERE module_id = $moduleID";
        $res = $con->query($assessID);
        $assessment_id = 0;
        while($row = $res->fetch_assoc()){
            $assessment_id = $row['assessment_id'];
        } 

        $query ="INSERT INTO assessment_completion (stud_id, assessment_id, result, comp_date) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($query);

        if($stmt) {
            $stmt->bind_param("iiis", $student_id, $assessment_id, $score, $completionDate);

            if($stmt->execute()) {
                echo "saved";
            }
            else {
                echo "Error saving results";
            }

            $stmt->close();
        }
        else {
            echo "Error saving results";
        }
    }

    if(isset($_GET['getAssessmentResult'])) {
        $studentID = $_GET['student_id'];
        $moduleID = $_GET['module_id'];
        
        $assessID = "SELECT assessment_id FROM assessments WHERE module_id = $moduleID";
        $res = $con->query($assessID);
        $assessment_id = 0;
        while($row = $res->fetch_assoc()){
            $assessment_id = $row['assessment_id'];
        } 

        $query = "SELECT * FROM assessment_completion WHERE stud_id = ? AND assessment_id = ?";
        $stmt = $con->prepare($query);

        if($stmt){
            $stmt->bind_param("ii", $studentID, $assessment_id);

            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows > 0){
                    $data = $result->fetch_assoc();
                    echo json_encode($data);
                } else {
                    echo json_encode(array("message" => "proceed"));
                }
                
            } else {
                echo json_decode(array("message" => "Error executing SQL statement"));
            }
        } else {
            echo json_encode(array("message"=> "Error executing SQL statement"));
        }
    }
?>