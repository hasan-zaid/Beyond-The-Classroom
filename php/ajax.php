<?php
include 'config.php';
var_dump($_POST);
if(isset($_POST['ename'])){
    $name = $_POST['ename'];
    $content = trim($_POST['content']);
    $materialid = $_POST['material'];
    $matlink = $_POST['matlink'];
    switch ($name){
        case 'name':
            mysqli_query($con,"UPDATE `modules` SET `module_name`='$content'");
            break;
        case 'tutor':
            mysqli_query($con,"UPDATE `tutors` SET `tutor_name`='$content'");
            break;
        case 'duration':
            mysqli_query($con,"UPDATE `modules` SET `module_time`='$content'");
            break;
        case 'desc':
            mysqli_query($con,"UPDATE `modules` SET `module_desc`='$content'");
            break;
        case 'material':
            mysqli_query($con,"UPDATE `materials` SET `material_name`='$content' WHERE `material_id`='$materialid'");
            break;
        case 'matlink':
            mysqli_query($con,"UPDATE `materials` SET `material_link`='$content' WHERE `material_id`='$materialid'");
            break;
    }
}
