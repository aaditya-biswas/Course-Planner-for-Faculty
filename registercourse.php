<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Scheduler</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f8ff; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { display: flex; width: 80%; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); }
        .left-panel { flex: 1; padding: 20px; background: #ffebcd; border-radius: 10px; animation: 21; ; }
        .right-panel { flex: 2; padding: 20px; background: #e6e6fa; border-radius: 10px; }
        h2, h3 { text-align: center; }
        input, select, button { width: 100%; padding: 10px; margin: 5px 0; border-radius: 5px; border: none; }
        button { background-color: #4caf50; color: white; cursor: pointer; transition: transform 0.2s; }
        button:hover { background-color: #45a049; transform: scale(1.05); }
        #calendar { display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; margin-top: 20px; }
        .day { border: 1px solid #000; padding: 10px; min-height: 50px; background-color: #fff; cursor: pointer; text-align: center; transition: background 0.3s ease-in-out, box-shadow 0.3s ease-in-out; }
        .day:hover { background-color: #d3d3d3; box-shadow: 0px 0px 10px rgba(0, 0, 255, 0.5); }
        .highlight { background-color: lightgreen; font-weight: bold; animation: fadeIn 0.5s ease-in-out, glow 1s infinite alternate; }
        ul { list-style: none; padding: 0; }
        li { background: #ffcccb; margin: 5px; padding: 10px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; animation: fadeIn 0.5s ease-in-out; }
        .remove-btn { background-color: red; color: white; border: none; padding: 5px; cursor: pointer; border-radius: 5px; transition: transform 0.2s; }
        .remove-btn:hover { background-color: darkred; transform: scale(1.1); }

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
<nav>
<div class="container">
   
        <>
        <div class="left-panel">
            <h2>Course Scheduler</h2>
            <label>Date: <input type="date" id="courseDate"></label>
            <label>Course Name: <input type="text" id="courseName" name = "courseName"></label>
            <label>Description: <input type="text" id="courseDesc"></label>
            <button onclick="addCourse()">Register Course</button>
            
            <h3>Registered Courses</h3>
            <ul id="courseList"></ul>
        </div>
        
        <div class="right-panel">
            <h3>Calendar</h3>
            <label>Select Month:</label>
            <select id="monthSelect" onchange="updateCalendar()">
                <option value="0">January</option>
                <option value="1">February</option>
                <option value="2" >March</option>
                <option value="3">April</option>
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
    </div>

    <script>
        let courses = [];

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
            for (let i = 1; i <= daysInMonth; i++) {
                let dayBox = document.createElement("div");
                dayBox.className = "day";
                let monthString = (selectedMonth + 1).toString().padStart(2, '0');
                let dayString = i.toString().padStart(2, '0');
                let dateString = `2025-${monthString}-${dayString}`;
                dayBox.textContent = i;
                if (courses.some(course => course.date === dateString)) {
                    dayBox.classList.add("highlight");
                }
                calendar.appendChild(dayBox);
            }
        }

        updateCalendar();
    </script>
</body>
</html>
