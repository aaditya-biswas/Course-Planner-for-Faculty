<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$servername = "localhost";
$username = "root";
$password = "";
$database = "se_project";
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $conn = mysqli_connect($servername, $username, $password, $database);
      $course = $_POST['AddCourse'];
      echo $course;
      echo "Session name: " . ($_SESSION["name"] ?? "Not Set");

      
      $stmt4 = $conn->prepare("SELECT * FROM courses WHERE `Course Code` = ?");
      $stmt4->bind_param("s",$course);
      $stmt4->execute();
      $result4 = $stmt4->get_result();
      if ($result4->num_rows > 0) {
        $stmt3 = $conn->prepare("SELECT `Course Code` FROM user_course WHERE Username= ?");
        echo $_SESSION["name"];
        $stmt3->bind_param("s",$_SESSION["name"]);
        
        $stmt3->execute();
        $result1 = $stmt3->get_result();
        if ($result1->num_rows > 0) {
            echo 1;
        } 
        $_SESSION["Added"] = $course;
    }
      else {
        $_SESSION["Added"] = 0;
    }


    
}
?>
