<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$servername = "localhost";
$username = "root";
$password = "";
$database = "se_project";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course = trim($_POST["RemoveCourse"]);
    echo $_SESSION["Courses"][0];
    
    if (!(in_array($course, $_SESSION["Courses"]))) {
        // Define the error message
        $errorMessage =
            "Error! You do not have this course. Please choose different course to delete.";

        // URL encode the error message to ensure it is safe to pass in the URL
        $encodedMessage = urlencode($errorMessage);

        // Redirect to the target page with the error message as a query parameter
        header(
            "Location: https://localhost//Course-Planner-for-Faculty//registercourse.php?error=" .
                $encodedMessage);
        exit();
    } 
    
    else {
            $conn = mysqli_connect($servername, $username, $password, $database);
            array_splice($_SESSION["Courses"],array_search($course,$_SESSION["Courses"]),1);
            array_splice($_SESSION["Days"],array_search($course,$_SESSION["Courses"]),1);
            $str1 = implode(", ",$_SESSION["Courses"]);
            $stmt5 = $conn->prepare(
                "UPDATE `user_course` SET `Course Code` = ? WHERE Username = ?"
            );
            $stmt5->bind_param("ss", $str1, $_SESSION["name"]);
            $stmt5->execute();
            $conn->commit();
        }
        header(
            "Location: registercourse.php"
        );
        $conn->close();
    }
?>
