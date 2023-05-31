<?php
    $con = new mysqli('localhost', 'root', '', 'fwdd');

    if($con->connect_error)
    {
        echo json_encode(array("message" => "Connection to Database has Failed !!"));
    }

    if(isset($_POST['check_email'])) {
        $email = $_POST['email'];
        $sql_1 = "SELECT * FROM students WHERE stud_email='$email' UNION SELECT * FROM tutors WHERE tutor_email='$email'";
        $sql_2 = "SELECT * FROM admin WHERE admin_email='$email'";
        $results_1 = $con->query($sql_1);
        $results_2 = $con->query($sql_2);

        if(mysqli_num_rows($results_1) > 0 || mysqli_num_rows($results_2) > 0) {
            echo "not_available";
        }
        else{
            echo "available";
        }
        exit();
    }

    if(isset($_POST['save-student'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $dob = $_POST['dob'];

        $query = "INSERT INTO students (stud_name, stud_email, stud_password, stud_dob, stud_status) VALUES ('$name', '$email', '".md5($password)."', '$dob', 1)";
        $results = $con->query($query);

        echo "Your Account Was Created Successfully";
        exit(); 
    }

    if(isset($_POST['save-tutor'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $dob = $_POST['dob'];

        $query = "INSERT INTO tutors (tutor_name, tutor_email, tutor_password, tutor_dob, tutor_status) VALUES ('$name', '$email', '".md5($password)."', '$dob', 1)";
        $results = $con->query($query);

        echo "Tutor Account Was Created Successfully";
        exit(); 
    }

    if(isset($_POST['activate'])) {
        $query = '';
        $id = $_POST['id'];
        $user = $_POST['user'];
        if($user == 'student') {
            $query = "UPDATE students SET stud_status = 1 WHERE stud_id=$id";
        }
        else {
            $query = "UPDATE tutors SET tutor_status = 1 WHERE tutor_id=$id";
        }

        $con->query($query);

        echo "$user Account Was Activated Successfully";
        exit(); 
    }

    if(isset($_POST['suspend'])) {
        $query = '';
        $id = $_POST['id'];
        $user = $_POST['user'];
        if($user == 'student') {
            $query = "UPDATE students SET stud_status = 0 WHERE stud_id=$id";
        }
        else {
            $query = "UPDATE tutors SET tutor_status = 0 WHERE tutor_id=$id";
        }

        $con->query($query);

        echo "$user Account Was Suspended Successfully";
        exit(); 
    }

    if(isset($_POST['updateProfile'])) {
        $id = $_POST['id'];
        $userType = $_POST['userType'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "";

        $stmt = null;

        if($userType == "student"){
            $query = "UPDATE students SET stud_name = ?, stud_email = ?, stud_password = ? WHERE stud_id = ?";
            $stmt = $con->prepare($query);
        }
        else if($userType == "tutor"){
            $query = "UPDATE tutors SET tutor_name = ?, tutor_email = ?, tutor_password = ? WHERE tutor_id = ?";
            $stmt = $con->prepare($query);
        }
        else{
            $query = "UPDATE admin SET admin_name = ?, admin_email = ?, admin_password = ? WHERE admin_id = ?";
            $stmt = $con->prepare($query);
        }

        $hashedPassword = md5($password);

        if($stmt) {
            $stmt->bind_param("sssi", $name, $email, $hashedPassword, $id);

            if($stmt->execute()){
                echo "Your Profile Details Have Been Updated Successfully";
            } else {
                echo json_encode(array("message" => "Error updating profile"));
            }

            $stmt->close();
        } else {
            echo json_encode(array("message" => "Error in SQL query"));
        }


        exit();
    }

    if(isset($_GET['getProfileData'])) {
        $id = $_GET['id'];
        $userType = $_GET['userType'];

        $query = "";
        $stmt = null;

        if($userType == "student"){
            $query = "SELECT stud_name as name, stud_email as email FROM students WHERE stud_id = ?";
            $stmt = $con->prepare($query);
        }
        else if($userType == "tutor"){
            $query = "SELECT tutor_name as name, tutor_email as email FROM tutors WHERE tutor_id = ?";
            $stmt = $con->prepare($query);
        }
        else{
            $query = "SELECT admin_name as name, admin_email as email FROM admin WHERE admin_id = ?";
            $stmt = $con->prepare($query);
        }

        if($stmt) {
            $stmt->bind_param("i", $id);
    
            if($stmt->execute()){
                $result = $stmt->get_result();
    
                if($result->num_rows > 0){
                    $data = $result->fetch_assoc();
                    echo json_encode($data);
                } else {
                    echo json_encode(array("message" => "No results found"));
                }
            } else {
                echo json_encode(array("message" => "Error executing statement: " . $stmt->error));
            }
    
            $stmt->close();
        } else {
            echo json_encode(array("message" => "Error preparing statement: " . $con->error));
        }
        exit();
    }
?>