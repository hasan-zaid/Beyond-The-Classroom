<?php
require_once('conn.php');

$email = $_POST['email'];
$password = $_POST['password'];

$q_admin = "SELECT * FROM admin WHERE admin_email = '$email'";
$r_admin = mysqli_query($conn, $q_admin);

$q_tutor = "SELECT * FROM tutors WHERE tutor_email = '$email'";
$r_tutor = mysqli_query($conn, $q_tutor);

$q_stud = "SELECT * FROM students WHERE stud_email = '$email'";
$r_stud = mysqli_query($conn, $q_stud);

// This is a very scuffed way to this lol

if(mysqli_num_rows($r_admin) > 0)
{
    // logged in as admin
    $sql = "SELECT * FROM admin WHERE admin_email = '$email' AND admin_password = '".md5($password)."'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) != 0)
    {
        // Account exists
        while($row = $result->fetch_assoc())
        {
            echo $row['admin_id'].",admin";
        }
    }
    else
    {
        // Email and password does not match
        echo "password_incorrect";
    }
}
else if(mysqli_num_rows($r_tutor) > 0)
{
    // logged in as tutor
    $sql = "SELECT * FROM tutors WHERE tutor_email = '$email' AND tutor_password = '".md5($password)."'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) != 0)
    {
        // Account exists
        while($row = $result->fetch_assoc())
        {
            echo $row['tutor_id'].",tutor";
        }
    }
    else
    {
        // Email and password does not match
        echo "password_incorrect";
    }
}
else if(mysqli_num_rows($r_stud) > 0)
{
    // logged in as student
    $sql = "SELECT * FROM students WHERE stud_email = '$email' AND stud_password = '".md5($password)."'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) != 0)
    {
        // Account exists
        while($row = $result->fetch_assoc())
        {
            echo $row['stud_id'].",student";
        }
    }
    else
    {
        // Email and password does not match
        echo "password_incorrect";
    }
}
else
{
    // email not found
    echo "account_not_found";
}

exit();
?>