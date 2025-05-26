<!DOCTYPE html>
<?php session_start() ?>
<?php if (isset($_SESSION['Error'])) {
  echo"<script type='text/JavaScript'>  
  alert('Invalid Credentials'); 
  
  </script>" ;
  unset($_SESSION["Error"]);
  }?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Course Planner for Faculty</title>
    <style>

        @keyframes example {
            from  {opacity: 0;}
            to {opacity: 1;}
            
        }
        body {
        background-image: url("Background.png");
        animation: fadeIn 2s ease-in-out;
        background-repeat: 
      }

      @keyframes fadeIn {
        from {
          display: none;
        }
        to {
          visi: block;
        }
      }
      </style>
  </head>
  <body >
    <div class=" navbar <nav class=navbar navbar-expand-lg navbar-light bg-light"></div>
    <div class="wrapper container-fluid p-5 text-center" style = "display:flex; flex-direction: row;justify-content:space-between;align-items: center;height : 100vh;">
    <div class="text-start text-white" style="max-width:60%;" > 
    <h1 class="m-2 "style="font-size: 100px; font-family:Lobster; align-items:center;">Course Planner for Faculty</h1>
    </div>
    <div style="background-color:#4F4F4F ; border-radius :20px; padding :20px;">
    <h2 style="color: white;align-items:center;"> Login Credentials</h2>
    <p  style = "color:white;"> Enter your ID and Password </p>
      <form class = "form-inline" id = "myForm" method="post" action = "Form.php">
        <br/><br/><br/>
          <label for="name" style="color:white;">Username:</label>
          <input type="text" name="name" id="uniqueID"><br/><br/><br/>
          <label for = "Password" style="color:white;"> Password:   </label> 
          
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
    </div>
        <div class = "text-center panel-footer">All rights reserved.
      </div>

    

  </body>
</html>
