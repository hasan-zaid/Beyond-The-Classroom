<?php
include 'php/config.php';

$id = '';
if (isset($_GET['mid'])) {
    $id = intval($_GET['mid']);
}
$data = mysqli_query($con, "SELECT * FROM `tutors` INNER JOIN `modules` ON `tutors`.`tutor_id`=`modules`.`tutor_id` WHERE `module_id`='$id' ");
$rows = mysqli_fetch_assoc($data);

$material = mysqli_query($con, "SELECT * FROM `materials` INNER JOIN `modules` ON `materials`.`module_id`=`modules`.`module_id` WHERE `materials`.`module_id`='$id' ");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $('document').ready(function() {
            if(sessionStorage.getItem("userType") === "student") {
                $("#editModuleBtn").hide();
                $(".editMaterialBtn").hide();
            }
            else if (sessionStorage.getItem("userType") === "tutor") {
                $("#assesmentQR").hide();
            }
            else if(sessionStorage.getItem("userType") === "admin") {
                alert("You don't have permission to access this page");
                removeSessionData();
                window.location.replace('../');
            }
            var id = sessionStorage.getItem('id');
            var userType = sessionStorage.getItem('userType');
            var img = document.getElementById('assessmentQR');
            var module_id = img.getAttribute('alt');

            fetch('https://api.ipify.org?format=json')
            .then(response => response.json())
            .then(data => {
                // In order for the QR code to be scanned properly on other devices:
                    // 1) The scannign device should be connected to the same network as the virtual server
                    //2) The IPv4 address in the string below 'serverClientIP' is to be changed to the client's own static IPv4 address
                var serverClientIP = '192.168.1.1';
                var assessment = `http://${serverClientIP}/Beyond%20the%20Classroom/student/qr-self-assessment.html?module_id=${module_id}&id=${id}&type=${userType}`;
                var encodedAssessmentURL = encodeURIComponent(assessment);
                img.src = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodedAssessmentURL}`;
            })
            .catch(error => alert('Error Generating Assessment QR Code!'));
        });
       
        function removeSessionData() {
                sessionStorage.clear();
                window.location.replace('./');
            }
    </script>
</head>

<body>
    <header
        class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-1 mb-4 border-bottom header ">
        <div class="col-md-3 mb-2 mb-md-0 side-margin"> <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
                <img class="icon-image" src="images/logo.png"> </a> </div>
        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="./" class="nav-link px-2">Home</a></li>
            <li><a href="modules.html" class="nav-link px-2">Modules</a></li>
            <li><a href="about-us.html" class="nav-link px-2">About Us</a></li>
            <li><a href="faq.html" class="nav-link px-2">FAQs</a></li>
        </ul>
        <div class="col-md-3 text-end side-margin"> <button type="button" class="btn btn-outline-primary" onclick="removeSessionData()">Logout</button> </div>
    </header>

    <div class="module-overview_container">
        <div class="module-overview_imageSection" id="assesmentQR">
            <img src="images/mathCard.jpg" class="module-overview_image" alt="avatar">
            <div class="module-overview_Qrcode">
                <p>
                    Take the self-asssessment by scanning the QR code
                </p>
                <img id="assessmentQR" style="width: auto; height: auto;" alt="<?php echo $rows['module_id']; ?>">
            </div>
        </div>
        <div class="module-overview_texts">
            <h2 class="module-overview_title">
                <?= $rows['module_name'] ?>
            </h2>
            <span>
                <?= $rows['tutor_name'] ?>
            </span>
            <span>
                Duration:
                <?= $rows['module_time'] ?> hours
            </span>
            <span>
                <a href="list-module-students.html?id=<?php echo $rows['module_id'];?>" style="color: #425f7e;">show students</a>
            </span>
            <div>
                <p>Overview:</p>
                <span>
                    <?= $rows['module_desc'] ?>
                </span>
            </div>
            <div style="display:flex;justify-content: flex-end;margin:0">
                <a href="tutor/module-edit.php?id=<?= $rows['module_id'] ?>" title="edit" style="display:flex;color:#535353" id="editModuleBtn"> 
                    <i class="i-ic-round-edit-note "></i>
                    Edit
                </a>
            </div>
        </div>

        <div class="module-overview_accordionContainer" style="margin-top:10px">
            <div class="tabs">
                <?php while ($mrows = mysqli_fetch_assoc($material)) { ?>
                    <div class="tab">
                        <input type="radio" id="rd<?= $mrows['material_id'] ?>" name="rd">
                        <label class="tab-label" for="rd<?= $mrows['material_id'] ?>">
                            <p><?= $mrows['material_name'] ?></p>
                            <div>
                                <img src="images/arrowIcon.svg" width="20" height="20" alt="arrowIcon">
                            </div>
                        </label>
                        <div class="tab-content">
                            <a href="<?= $mrows['material_link'] ?>"><button>Download</button></a>
                            <a href="tutor/material-edit.php?id=<?= $mrows['material_id'] ?>&mid=<?php echo $id;?>" class="editMaterialBtn"><button>Edit</button></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <footer class="bg-light text-center text-lg-start">
            <div class="container p-4">
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                        <h5 class="text-uppercase">About Us</h5>
                        <p> Beyond the Classroom is an innovative e-learning platform that brings education directly to your fingertips. We believe that learning should not be confined to traditional classrooms, and our goal is to provide accessible and engaging online courses for students of all ages. </p>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Our Mission</h5>
                        <p> Our mission is to revolutionize the way education is delivered by harnessing the power of technology. We aim to make learning more convenient, flexible, and personalized for every learner, regardless of their location or schedule. We strive to create a supportive and inclusive learning environment where students can thrive and reach their full potential. </p>
                    </div>
                </div>
            </div>
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);"> © 2023 Copyright: <a class="text-dark" href="../about-us.html">Beyond The Classroom</a> </div>
        </footer>
</body>

</html>