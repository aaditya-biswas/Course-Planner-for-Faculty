<!DOCTYPE html>
<?php session_start() ?>
<?php if (isset($_SESSION['Error'])) {
  echo"<script type='text/JavaScript'>  
  alert('Invalid Credentials'); 
  
  </script>" ;
          
  }?>
<html>
  <head>
    <meta charset="UTF-8" />
    <!-- Adjusted CSP to allow inline styles -->
    <link rel="stylesheet" href="index.css">
    
    <title>Course Planner for Faculty</title>
  </head>
  <body>
    
    

    <h1>Course Planner for Faculty</h1>
    <h2> Login Credentials</h2>
    <section>
    <h3> Enter your ID and Password </h3>
    </section>
    <div id = "Div1">
      <form id = "myForm" method="post" action = "http://localhost/Form.php">
        <br/><br/><br/>
          <label for="name">Username:</label>
          <input type="text" name="name" id="uniqueID"><br/><br/><br/>
          <label for = "Password"> Password:   </label> 
          
          <input type = "password" name = "Password" id = "Password" style="margin-left: 3px;"><br/><br/>
          <input type="checkbox" onclick="myfunc()" id = "one" style="text-align: left;"> Show Password <br/><br/><br/>
          <input id = "submit" type="submit"  ><br/><br/><br/>


      </form>
      <script>
        function myfunc() {
        
          
          var x = document.getElementById("Password");
          if (x.type === "password") x.type ="text";
          else {
          x.type = "password";
          }

        
        }
        

        </script>
    </div>
  </body>
</html>
