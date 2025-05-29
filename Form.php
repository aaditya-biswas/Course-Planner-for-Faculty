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

    $name = htmlspecialchars($_POST["name"] ?? '');
    $password = htmlspecialchars($_POST["Password"] ?? '');

    $stmt = $conn->prepare("SELECT * FROM users WHERE Username= ? AND Password = ?");
    $stmt->bind_param("ss", $name,   $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $_SESSION["name"] = $name;
    $_SESSION["Password"] = $password;
    
    $stmt2 = $conn->prepare("SELECT * FROM user_course WHERE Username= ?");
    $stmt2->bind_param("s",$name);
    $stmt2->execute();

    $courses = trim($stmt2->get_result()->fetch_assoc()["Course Code"]);
    $_SESSION["Days"] = [];
    $_SESSION["Courses"] = explode(", ",$courses);
    for ($i=0; $i <sizeof($_SESSION["Courses"]) ; $i++) { 
    }
    for ($i=0; $i <sizeof($_SESSION["Courses"]) ; $i++) { 
      $stmt3 = $conn->prepare("SELECT `Day` FROM `slot_day` WHERE `slot_day`.`Day_ID` IN (SELECT `slot_time`.`Day_ID` FROM `slot_time` WHERE `slot_time`.`Slot_ID` = (SELECT `SLOT` FROM `courses` WHERE `courses`.`Course Code` = ?))");
      $stmt3->bind_param("s",$_SESSION["Courses"][$i]);
      $stmt3->execute();
      $result1 = $stmt3->get_result();
      $_SESSION["Days"][$i] = array_column($result1->fetch_all(),0);
    }

    
    

    if ($result->num_rows > 0) {

      
      header("Location: registercourse.php");
      
      exit(); // Stop further execution
    }
   else {
      $_SESSION['Error'] = "You left one or more of the required fields.";

      header("Location:  index.php");

    }
    $conn->close();
}
else {
  
}
?>
