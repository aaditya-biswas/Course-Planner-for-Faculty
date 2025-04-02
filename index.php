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
    $stmt->bind_param("ss", $name, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["Password"] = $_POST["Password"];
    if ($result->num_rows > 0) {
      ob_start(); // Start output buffering

      header("Location: https://localhost/registercourse.php");
      
      exit(); // Stop further execution
    }
   else {
      echo"<script type='text/JavaScript'>  
      alert('Invalid Credentials'); 
      </script>" ;
      header("Location: https://localhost/index.html");
      
    }
    $conn->close();
}
else {
  
}
?>