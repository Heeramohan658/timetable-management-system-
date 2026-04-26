<?php
$conn = new mysqli("localhost","root","1234","timetablesystem");

if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $course = $_POST['course'];
    $division = $_POST['division'];
    $day = $_POST['day'];
    $time_slot = $_POST['time_slot'];
    $subject = $_POST['subject'];
    $faculty = $_POST['faculty'];
    $room = $_POST['room'];

    $stmt = $conn->prepare("INSERT INTO timetable 
    (course, division, day, time_slot, subject, faculty, room)
    VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssss", $course, $division, $day, $time_slot, $subject, $faculty, $room);

    if($stmt->execute()){
        echo "✅ Saved Successfully";
    } else {
        echo "Error: ".$stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>