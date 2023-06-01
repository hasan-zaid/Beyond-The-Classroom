<?php
$servername = "localhost";
$username = "root";
$password = ""; // Enter your MySQL password here
$dbname = "fwdd";

$con = mysqli_connect($servername, $username, $password, $dbname);

if (isset($_POST['delete_module'])) {
    $module_id = $_POST['module_id'];
    
    // Updating module status to 0
    $update_module_status = mysqli_query($con, "UPDATE `modules` SET `module_status`=0 WHERE `module_id`='$module_id'");

    if (!$update_module_status) {
        printf("Error: %s\n", mysqli_error($con));
        exit();
    }

    // Refresh the page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$data = mysqli_query($con,"SELECT * FROM `tutors` INNER JOIN `modules` ON `tutors`.`tutor_id`=`modules`.`tutor_id` WHERE `modules`.`module_status`=1");

if (!$data) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Main Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../style/global-styles.css">
    <link rel="stylesheet" type="text/css" href="../style/tutor-main-page.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>

            if(!(sessionStorage.getItem('userType') === 'tutor')) {
                alert("You don't have permission to access this page");
                removeSessionData();
                window.location.replace('../');
            }

            function removeSessionData() {
                sessionStorage.clear();
                window.location.replace('../');
            }
    </script>  
</head>
<body>
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-1 mb-4 border-bottom header "> 
        <div class="col-md-3 mb-2 mb-md-0 side-margin"> 
            <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
                 <img class="icon-image" src="../images/logo.png"> </a> 
        </div>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="../" class="nav-link px-2">Home</a></li>
            <li><a href="../modules.html" class="nav-link px-2">Modules</a></li>
            <li><a href="../about-us.html" class="nav-link px-2">About Us</a></li>
            <li><a href="../faq.html" class="nav-link px-2">FAQs</a></li>
        </ul>
        
        <div class="col-md-3 text-end side-margin">
        <button type="button" class="btn btn-primary" onclick="window.location.href = '../update-profile.html'">Edit Profile</button>
             <button type="button" class="btn btn-outline-primary" onclick="removeSessionData()">Logout</button>
        </div> 
    </header>

    <h1>Dashboard</h1>
    
    <button type="button" class="btn btn-primary" onclick="window.location.href = 'create-module.html'" data-bs-toggle="button">
        Create new Module <span class="ms-2"><i class="bi bi-plus-lg"></i></span>
    </button>    

    <div class="container">
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php while($rows = mysqli_fetch_assoc($data)) { ?>
        <div class="course-list">
            <a class="course-box">
                <img src="../images/mathCard.jpg" alt="course-img">
                <div>
                    <h3 onclick= "window.location.href='../module-view.php?mid=<?php echo $rows['module_id'];?>'" style="cursor: pointer;"><?= $rows['module_name'] ?></h3>
                    <span class="tutor"><?= $rows['tutor_name'] ?></span>
                    <div class="info">
                        Duration: <?= $rows['module_time'] ?> hours<br>
                        Free course
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" name="edit_module" class="btn btn-secondary" onclick="window.location.href = 'module-edit.php?id=<?php echo $rows['module_id'];?>'"><i class="bi bi-pen"></i></button>
                        <button type="button" name="add_to_module" class="btn btn-info" onclick="window.location.href = 'add-self-assessment.html?mid=<?php echo $rows['module_id'];?>'"><i class="bi bi-folder-plus"></i></button>
                        <button type="button" name="delete_module" class="btn btn-danger" onclick="return confirm('Do you really want to delete this module?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </a>      
        </div>
        <?php } ?>
    </div>
</div>

<footer class="bg-light text-center text-lg-start">
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);"> © 2023 Copyright: <a class="text-dark" href="../about-us.html">Beyond The Classroom</a> </div>
        </footer>



</body>
</html>
