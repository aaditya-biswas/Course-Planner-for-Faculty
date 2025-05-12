<?php session_start(); ?>

<?php
// Check if an error message is present in the query parameters

if (isset($_GET['error'])) {

    // Decode the error message

    $errorMessage = urldecode($_GET['error']);

    echo "<script type='text/javascript'>  

    alert('".addslashes($errorMessage)."');

    </script>";
}
?>

<!-- Specify format -->

<!DOCTYPE html>

<html lang="en">

<head>

<!-- Specifies meta variables -->
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Title -->

    <title>Course Scheduler</title>

<!-- Importing Icons and Jquery into the code -->  

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel = "stylesheet" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Specifying styles in the header-->

    <style>

        body { font-family: Arial, sans-serif; background-color:rgb(0, 136, 255);justify-content:space-evenly; height: 100vh; }
        
        .container { display: flex; justify-content: flex-start; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); margin-top: 10px}
        
        .left-panel { flex: 1; margin: 5px;padding: 20px; background: #ffebcd; border-radius: 10px; animation: 21;  }
        
        .right-panel { flex: 1 2;margin: 5px; padding: 20px; background: #e6e6fa; border-radius: 10px; }
        
        .rightmost-panel {display: flex;  flex: 1; padding: 5px; background:rgb(239, 239, 25); border-radius: 10px; text-align: center;flex-direction: column; }
        
        .add-course {display:flex ;background-color:greenyellow ; margin:5px;border-radius: 10px;text-align: center; color: purple;align-items: stretch; flex-direction: column;}
        
        .Table {background-color:  #e6e6fa; margin: 20px;overflow-y: auto; }
        
        h2, h3 { text-align: center; }
        
        input, select, button { width: 100%; padding: 10px; margin: 5px 0; border-radius: 5px; border: none; }
        
        button { background-color: #4caf50; color: white; cursor: pointer; transition: transform 0.2s; }
    
        button:hover { background-color: #45a049; transform: scale(1.05); }
        
        #calendar { display: grid; grid-template-columns: repeat(7,1fr); gap: 5px; margin-top: 20px;}
        
        .day { border: 1px solid #000; padding: 10px; min-height: 50px; background-color: #fff; cursor: pointer; text-align: center; transition: background 0.3s ease-in-out, box-shadow 0.3s ease-in-out; }
        
        .day:hover { background-color: #d3d3d3; box-shadow: 0px 0px 10px rgba(0, 0, 255, 0.5); }
        
        .highlight { background-color: lightgreen; font-weight: bold; animation: fadeIn 0.5s ease-in-out, glow 1s infinite alternate; text-decoration-thickness: 10px;}
        
        #remove {margin-top: auto;}
        
        ul { list-style: none; padding: 0; }
        
        .Submit:hover {transform: scale(1.05);}
        
        li { background: #ffcccb; margin: 7px; padding: 10px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; animation: fadeIn 0.5s ease-in-out; }

        
        .remove-btn { background-color: red; color: white; border: none; padding: 2px; cursor: pointer; border-radius: 5px; transition: transform 0.2s; width:25%; height: 10px;}
        
        .remove-btn:hover { background-color: darkred; transform: scale(1.1); }
        
        .trsh {padding: 5px;background-color: red;color:white}
        .trsh:hover {scale: 1.05;}
        
        .color0 {background-color: tan;}
        
        .color1 {background-color: aqua;}
        
        .color2 {background-color: lawngreen;}
        
        .color3 {background-color: violet;}
        
        .dicolor0 {color: tan;}
        
        .dicolor1 {color : aqua}
        
        .dicolor2 {color: lawngreen}
        
        .dicolor3 {color: violet;}
        
        /*Key frames for animations*/ 
        
        @keyframes fadeIn {
    
            from { opacity: 0; transform: translateY(-10px); }
    
            to { opacity: 1; transform: translateY(0); }
    
        }

        @keyframes glow {
    
            from { box-shadow: 0px 0px 5px rgba(0, 255, 0, 0.5); }
    
            to { box-shadow: 0px 0px 20px rgba(0, 255, 0, 1); }
    
        }

        
    </style>

</head>

<body>

    <!-- Creating the navigation bar with respctive fields -->

    <div id="navbar" style="background-color: white; height: 50px; display: flex; align-items: center ;border-radius: 10px ; padding: 0 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
      
    <a href="https://docs.google.com/spreadsheets/d/1TRwJQ8fTEPdVTX2cQMHsaPJkPz8wFeKLtb-myc2lqi0/edit?gid=946608464#gid=946608464" style="margin-right: 20px; text-decoration: none; color: black;">Courses</a>

    <a href="#" style="margin-right: 20px; text-decoration: none; color: black;">TA</a>

    <a href="#" style="text-decoration: none; color: black;">Exam</a>

</div>

<!--Flexible and dynamic display using flexbox-->
<div class="container" display = "flex" justify-content = "center">
        
    <div class="left-panel">

        <h2>Events</h2>

        <label>Date: <input type="date" id="EventDate"></label>

        <label>Event Name: <input type="text" id="EventName" name = "EventName"></label>
        
        <label>Description: <input type="text" id="EventDesc"></label>
        
        <button onclick="addEvent()">Add Events</button>
        
        <h3>Events</h3>
        
        <ul id="EventList">
        
        </ul>
        
    </div>
        
    <div class="right-panel">

        <h3>Calendar</h3>
    
        <label>Select Month:</label>
    
        <select id="monthSelect" onchange="updateCalendar()"> <!-- Listing down all inputs for Month -->
    
        <option value="0" >January</option>
    
        <option value="1">February</option>
    
        <option value="2" >March</option>
        
        <option value="3" >April</option>
    
        <option value="4">May</option>
    
        <option value="5">June</option>
    
        <option value="6">July</option>
    
        <option value="7">August</option>
    
        <option value="8">September</option>
    
        <option value="9">October</option>
    
        <option value="10">November</option>
    
        <option value="11">December</option>
        
        </select>
    
        <!-- Dynamic Calendar Structure -->
        <div id="calendar"></div>
        
        </div>
    
        <div class = "rightmost-panel" >
    
        <h1> Registered Courses List </h1>
    
            <div class = "Table">
    
            <ul id = "List" >
    
            </ul>
    
            </div>
        <!-- Input for the course to Delete -->
        <form id = "remove" name = "remove" method = "post" action = "Delete_Course.php">
    
        <label for="RemoveCourse" style = "text-decoration: bold; color:aquawhite;">Delete Course</label>
    
        <input type="text" name="RemoveCourse" id = "r_course" style="width :40%;">
    
        <input class = "Submit" id = "submit" type="submit"   style="width :40%;">
    
        </form>
    
        </div>
        <!-- Input for Adding Courses -->
        <div class = "add-course" >
    
        <h1> Add Courses </h1>
    
        <form id = "myForm" method="post" action = "Add_Course.php" >
    
        <br/><br/><br/>
    
        <label for="AddCourse" style = "text-decoration: bold; color:aquawhite;">Enter Course Name:</label>
    
        <input type="text" name="AddCourse"  style="width :40%;"><br/><br/><br/>
    
        <input class = "Submit" id = "submit" type="submit"   style="width :20%;" >
    
        <button type="submit" style="display:none;">Submit</button>

        </form>
      
        </div>

    </div>


    <script>
        // Storing the events in an array

        let events = [];
        
        // Storing the Days data for each Course
        var days = <?= json_encode(
        
        $_SESSION["Days"],
            
        JSON_UNESCAPED_UNICODE
        
        ) ?>;

        // Storing the Courses each User Has
        
        var myvar = <?= json_encode(
        
        $_SESSION["Courses"],
        
        JSON_UNESCAPED_UNICODE
        
        ) ?>;
        // List of weekdays zero indexed 
        
        const week_day =  ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        
        const date = new Date();
        
        // Function to add events with error handling

        function addEvent() {

            let date = document.getElementById("EventDate").value;
        
            let name = document.getElementById("EventName").value;
        
            let desc = document.getElementById("EventDesc").value;
            
            if (!date || !name || !desc) {
        
                alert("Please fill all fields");
        
                return;
            }  
        
            events.push({ date, name, desc });
        
            updateEventList();
        
            updateCalendar();
        }
        
        // Function to remove Events
        
        function removeEvent(index) {
          
            events.splice(index, 1);
          
            updateEventList();
          
            updateCalendar();
        }
        
        // Function for getting list of all Events and updating on deletion
        
        function updateEventList() {
        
            let list = document.getElementById("EventList");
        
            list.innerHTML = "";
        
            events.forEach((Event, index) => {
        
                let item = document.createElement("li");
        
                item.innerHTML = `${Event.date}: ${Event.name} - ${Event.desc} <button class='remove-btn' onclick=" removeEvent(${index});">Remove</button>`;
        
                list.appendChild(item);
        
            });
        }

        // Function for highlighting the boxes in which the respective classes are scheduled

        function highlight_course_days(days_list , day,dayBox) {
            for (let index = 0; index < days_list.length; index++) {
                let element = days_list[index];
                if (element.includes(day)){
                    dayBox.classList.add("highlight")
                    let rep = document.createElement("span");  
                    rep.className = `dicolor${index}`;
                    rep.innerHTML = "&diams;";
                    dayBox.appendChild(rep);     
                }
            }
        }

        // Function for updating the Calendar with respect to the Courses and events list;  
        
        function updateCalendar() {
            let calendar = document.getElementById("calendar");
            calendar.innerHTML = "";
            let selectedMonth = parseInt(date.getMonth());

            
            let daysInMonth = new Date(2025, selectedMonth + 1, 0).getDate();
            
            
            let weekday = new Date(2025, selectedMonth, 1).getDay(); // Obtaining the current weekday

            // For each day we append a day box in the specified grid template columns 
            
            
            for (let i = 1; i <= daysInMonth; i++) {
                let dayBox = document.createElement("div");
                dayBox.className = "day";
                let monthString = (selectedMonth + 1).toString().padStart(2, '0');
                let dayString = i.toString().padStart(2, '0');
                let we_day = week_day[(weekday+i-1)%7];
                let dateString = `2025-${monthString}-${dayString}`;
                
                dayBox.textContent = `${i} \n ${we_day}\n`;
                if (i == date.getDate()) {  // Underlining today's date
                
                    dayBox.style.textDecoration = "underline";
                    dayBox.style.textDecorationColor = "blue";
                }
                
                // If there are some events than adding highlighting it

                if (events.some(Event => Event.date === dateString)) {
                   
                    dayBox.classList.add("highlight");
                
                }
                highlight_course_days(days,we_day,dayBox);
                calendar.appendChild(dayBox);
            }
        }
        // Getting and setting up the registed course list
        function get_courses() {
            


            let x =document.getElementById("List");
            x.innerHTML = "";
            for(let i = 0; i < Object.keys(myvar).length; i++) {
                let item = document.createElement("li");
                
                item.classList.add(`color${(i)%4}`);
                let icons = 'fas fa-trash';
                
                let iconHtml = `${Object.values(myvar)[i]} <i class = "${icons} trsh"> </i>`;
                
                item.innerHTML = iconHtml;
                x.appendChild(item);
                item.querySelector("i").addEventListener("click",() => remove_Course(i));   
            }
        
        }
        function remove_Course(i) {
            let course_ = myvar[i];
            myvar.splice(i,1);
            days.splice(i,1);
            $.post ( "Delete_Course.php", {
                RemoveCourse :course_
            }
            );
            get_courses();
            updateCalendar();
        }

    get_courses();
    updateCalendar();
   
   </script>

</body>

</html>
