<?php
require_once("conn.php");

if(isset($_POST['add_module']))
{
    $tutor = $_POST['tutor'];
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $time = $_POST['time'];

    $sql = "INSERT INTO modules (tutor_id, module_name, module_desc, module_time, module_status)
            VALUES ($tutor, '$name', '$desc', $time, 1)";
    $result = mysqli_query($conn, $sql);

    if($result)
    {
        // echo the id for the newly created module
        $get_id = mysqli_query($conn, "SELECT module_id FROM modules ORDER BY module_id DESC LIMIT 1");

        while($row = $get_id->fetch_assoc())
        {
            echo $row['module_id'];
        }
    }
    else
    {
        echo mysqli_error($conn);
    }
    
    exit();
}

if(isset($_POST['add_material']))
{
    $module = $_POST['module'];
    $name = $_POST['mat-name'];
    $link = $_POST['mat-link'];
    $date = date('d-m-Y');

    $sql = "INSERT INTO materials (module_id, material_name, material_link, date_added)
            VALUES ($module, '$name', '$link', '$date')";
    $result = mysqli_query($conn, $sql);

    if(!$result)
    {
        echo mysqli_error($conn);
    }

    exit();
}

?>