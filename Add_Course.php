<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$servername = "localhost";
$username = "root";
$password = "";
$database = "se_project";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course = trim(htmlspecialchars($_POST["AddCourse"]));

    if (in_array($course, $_SESSION["Courses"])) {
        // Define the error message
        $errorMessage =
            "Error! You have already registered for this course. Please choose different course.";

        // URL encode the error message to ensure it is safe to pass in the URL
        $encodedMessage = urlencode($errorMessage);

        // Redirect to the target page with the error message as a query parameter
        header(
            "Location: registercourse.php?error=" .
                $encodedMessage);
        exit();
    } else {
        $conn = mysqli_connect($servername, $username, $password, $database);

        $stmt4 = $conn->prepare(
            "SELECT * FROM courses WHERE `Course Code` = ?"
        );

        $stmt4->bind_param("s", $course);
        $stmt4->execute();
        $result4 = $stmt4->get_result();
        if ($result4->num_rows > 0) {
            $stmt3 = $conn->prepare(
                "SELECT `Course Code` FROM user_course WHERE Username= ?"
            );
            $stmt3->bind_param("s", $_SESSION["name"]);
            $stmt3->execute();
            $result1 = $stmt3->get_result();
            if ($result1->num_rows > 0) {
                $str1 = $result1->fetch_assoc()["Course Code"];
                if ($str1 == "") {
                    $add_course = $course;
                } else {
                    $add_course = $str1 . ", " . $course;
                }
                $_SESSION["Courses"][] = $course;
                $stmt5 = $conn->prepare(
                    "UPDATE `user_course` SET `Course Code` = ? WHERE Username = ?"
                );
                $stmt5->bind_param("ss", $add_course, $_SESSION["name"]);
                $stmt5->execute();
                $conn->commit();
                $stmt6 = $conn->prepare("SELECT `Day` FROM `slot_day` WHERE `slot_day`.`Day_ID` IN (SELECT `slot_time`.`Day_ID` FROM `slot_time` WHERE `slot_time`.`Slot_ID` = (SELECT `SLOT` FROM `courses` WHERE `courses`.`Course Code` = ?))");
                $stmt6->bind_param("s",$course);
                $stmt6->execute();
                $result_stmt6 = $stmt6->get_result();
                $_SESSION["Days"][]=array_column($result_stmt6->fetch_all(),0);
            }   
            $_SESSION["Added"] = $course;
        } else {
            $_SESSION["Added"] = 0;
        }
        var_dump($_SESSION["Days"]);
        header(
            "Location: registercourse.php"
        );
        $conn->close();
    }
}
?>
