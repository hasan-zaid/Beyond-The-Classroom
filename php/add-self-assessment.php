<?php

    $con = new mysqli('localhost', 'root', '', 'fwdd');

    if($con->connect_error)
    {
        echo "Connection to the database has failed !!";
    }

    // check whether assessment exists for this module already
    if(isset($_POST['check'])) {
        $moduleID = $_POST['module_id'];
        $query = "SELECT * FROM assessments WHERE module_id = $moduleID";
        $result = mysqli_query($con, $query);

        // exists
        if(mysqli_num_rows($result) != 0)
        {
            echo 1;
        }
    }

    if(isset($_POST['addAssessment'])){
        $moduleID = $_POST['module_id'];
        $questions = json_decode($_POST['assessment'], true);

        $query = "INSERT INTO assessments (module_id) VALUES ('$moduleID')";
        $result = mysqli_query($con, $query);
        
        $assessmentAdded = false;

        foreach ($questions as $question) {
            $questionText = $question['questionText'];
            $choices = $question['choices'];
            $correctAnswer = $question['correctAnswer'];
        
            $query_2 = "INSERT INTO questions (assessment_id, question_title, choices, answer) VALUES ((SELECT assessment_id FROM assessments ORDER BY assessment_id DESC LIMIT 1), ?, ?, ?)";
            $stmt = $con->prepare($query_2);

            if($stmt) {
                $stmt->bind_param("sss", $questionText, $choices, $correctAnswer);
    
                if($stmt->execute()){
                    $assessmentAdded = true;
                } else {
                    echo "Error Adding Assessment";
                }
        
                $stmt->close();
            } else {
                echo "SQL Query Error";
            }
        }
        
        if($assessmentAdded) {
            echo "Assessment Has Been Added Successfully";
        }
    }
?>