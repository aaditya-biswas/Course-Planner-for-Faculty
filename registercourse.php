<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Scheduler</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel = "stylesheet" crossorigin="anonymous">
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
        
        ul { list-style: none; padding: 0; }
        .Submit:hover {transform: scale(1.05);}
        li { background: #ffcccb; margin: 7px; padding: 10px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; animation: fadeIn 0.5s ease-in-out; }
        .remove-btn { background-color: red; color: white; border: none; padding: 2px; cursor: pointer; border-radius: 5px; transition: transform 0.2s; width:25%; height: 10px;}
        .remove-btn:hover { background-color: darkred; transform: scale(1.1); }
        i {padding: 5px;background-color: red;color:white}

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
<div id="navbar" style="background-color: white; height: 50px; display: flex; align-items: center; padding: 0 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
      <a href="#" style="margin-right: 20px; text-decoration: none; color: black;">Courses</a>
      <a href="#" style="margin-right: 20px; text-decoration: none; color: black;">TA</a>
      <a href="#" style="text-decoration: none; color: black;">Exam</a>
    </div>
<div class="container" display = "flex" justify-content = "center">
    
        <div class="left-panel">
            <h2>Course Scheduler</h2>
            <label>Date: <input type="date" id="courseDate"></label>
            <label>Course Name: <input type="text" id="courseName" name = "courseName"></label>
            <label>Description: <input type="text" id="courseDesc"></label>
            <button onclick="addCourse()">Register Course</button>
            
            <h3>Events</h3>
            <ul id="courseList">
            </ul>
        </div>
        
        <div class="right-panel">

            <h3>Calendar</h3>
            <label>Select Month:</label>
            <select id="monthSelect" onchange="updateCalendar()">
                <option value="0">January</option>
                <option value="1">February</option>
                <option value="2" >March</option>
                <option value="3" selected>April</option>
                <option value="4">May</option>
                <option value="5">June</option>
                <option value="6">July</option>
                <option value="7">August</option>
                <option value="8">September</option>
                <option value="9">October</option>
                <option value="10">November</option>
                <option value="11">December</option>
            </select>
            <div id="calendar"></div>
            


        </div>
        <div class = "rightmost-panel" >
             <h1> Registered Courses List </h1>
            <div class = "Table">
                <ul id = "List" >
                </ul>
            </div>
        </div>
        <div class = "add-course" >
            <h1> Add Courses </h1>
            <form id = "myForm" method="post" action = "http://localhost/Add_Course.php">
                <br/><br/><br/>
            <label for="AddCourse" style = "text-decoration: bold; color:aquawhite;">Enter Course Name:</label>
            <input type="text" name="AddCourse"  style="width :40%;"><br/><br/><br/>
            <input class = "Submit" id = "submit" type="submit"   style="width :20%;" >


            </form>
        </div>
    

    </div>


    <script>
        let courses = [];
        var days = <?= json_encode(
            $_SESSION["Days"],
            JSON_UNESCAPED_UNICODE
        ) ?>;
        const week_day =  ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var myvar = <?= json_encode(
            $_SESSION["Courses"],
            JSON_UNESCAPED_UNICODE
        ) ?>;
        const date = new Date();

        function addCourse() {
            let date = document.getElementById("courseDate").value;
            let name = document.getElementById("courseName").value;
            let desc = document.getElementById("courseDesc").value;
            
            if (!date || !name || !desc) {
                alert("Please fill all fields");
                return;
            }
            
            courses.push({ date, name, desc });
            updateCourseList();
            updateCalendar();
        }


        function removeCourse(index) {
            courses.splice(index, 1);
            updateCourseList();
            updateCalendar();
        }

        function updateCourseList() {
            let list = document.getElementById("courseList");
            list.innerHTML = "";
            courses.forEach((course, index) => {
                let item = document.createElement("li");
                item.innerHTML = `${course.date}: ${course.name} - ${course.desc} <button class='remove-btn' onclick="removeCourse(${index})">Remove</button>`;
                list.appendChild(item);
            });
        }

        function updateCalendar() {
            let calendar = document.getElementById("calendar");
            calendar.innerHTML = "";
            let selectedMonth = parseInt(document.getElementById("monthSelect").value);
            let daysInMonth = new Date(2025, selectedMonth + 1, 0).getDate();
            
            
            let weekday = new Date(2025, selectedMonth, 1).getDay();
            for (let i = 1; i <= daysInMonth; i++) {
                let dayBox = document.createElement("div");
                dayBox.className = "day";
                let monthString = (selectedMonth + 1).toString().padStart(2, '0');
                let dayString = i.toString().padStart(2, '0');
                let we_day = week_day[(weekday+i-1)%7];
                let dateString = `2025-${monthString}-${dayString}`;
                
                dayBox.textContent = `${i} \n ${we_day}`;
                if (i == date.getDate()) {
                
                    dayBox.style.textDecoration = "underline";
                    dayBox.style.textDecorationColor = "blue";
                }
                if (courses.some(course => course.date === dateString)) {
                    dayBox.classList.add("highlight");
                }
                if (days.includes(we_day)) {
                    dayBox.classList.add("highlight");
                }
                calendar.appendChild(dayBox);
            }
        }
        function display() {
            alert("das");
        }
        function get_courses() {
            


            let x =document.getElementById("List");
            
            for(let i = 0; i < Object.keys(myvar).length; i++) {
                let item = document.createElement("li");
                let icons = 'fas fa-trash';
                let iconHtml = `${Object.values(myvar)[i]} <i class="${icons} Submit" onclick="removeListItem(${i})"></i>`;
                item.innerHTML = iconHtml;
                x.appendChild(item);
            }
            
        
        }

        function removeListItem(item) {
            myvar.splice(item,1);
            let trashIcons = document.getElementsByClassName("fas fa-trash");
            if (trashIcons[item]) {
                let listItem = trashIcons[item].closest("li"); // Get the parent <li> element
                if (listItem) {
                    listItem.parentNode.removeChild(listItem); // Remove the <li> element
                }
            }
            document.getElementById("List").innerHTML= ``;
            get_courses();
            return false;
        }
        
    // Add event listeners to the delete buttons
    // display();    
    get_courses();
        
    updateCalendar();
    </script>
</body>
</html>
