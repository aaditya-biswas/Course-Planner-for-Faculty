<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the input value using the name attribute
    $username = htmlspecialchars($_POST['username']);
    
    // Now you can use the $username variable as needed
    //echo "The submitted username is: " . $username;
}
?>