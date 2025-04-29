<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$servername = "localhost";
$username = "root";
$password = "";
$database = "se_project";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $name = $_POST["name"] ?? '';
    $password = $_POST["Password"] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE Username= ? AND Password = ?");
    $stmt->bind_param("ss", $name,   $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["Password"] = $_POST["Password"];
    
    $stmt2 = $conn->prepare("SELECT * FROM user_course WHERE Username= ?");
    $stmt2->bind_param("s",$name);
    $stmt2->execute();

    $courses = trim($stmt2->get_result()->fetch_assoc()["Course Code"]);
    $_SESSION["Days"] = [];
    $_SESSION["Courses"] = explode(", ",$courses);
    for ($i=0; $i <sizeof($_SESSION["Courses"]) ; $i++) { 
    }
    for ($i=0; $i <sizeof($_SESSION["Courses"]) ; $i++) { 
      echo "1";
      $stmt3 = $conn->prepare("SELECT `Day` FROM `slot_day` WHERE `slot_day`.`Day_ID` IN (SELECT `slot_time`.`Day_ID` FROM `slot_time` WHERE `slot_time`.`Slot_ID` = (SELECT `SLOT` FROM `courses` WHERE `courses`.`Course Code` = ?))");
      $stmt3->bind_param("s",$_SESSION["Courses"][$i]);
      echo $_SESSION['Courses'][$i];
      $stmt3->execute();
      $result1 = $stmt3->get_result();
      while ($row = $result1->fetch_row()){
          echo $row[0];

          $_SESSION["Days"][] =  $row[0];
      }
    }
    

    if ($result->num_rows > 0) {
      // ;
      // ob_start(); // Start output buffering
      
      header("Location: https://localhost//Course-Planner-for-Faculty//registercourse.php");
      
      exit(); // Stop further execution
    }
   else {
      $_SESSION['Error'] = "You left one or more of the required fields.";

      header("Location:  https://localhost//Course-Planner-for-Faculty//index.php");

    }
    $conn->close();
}
else {
  
}
?>