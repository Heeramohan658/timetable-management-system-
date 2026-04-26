<?php
$conn = new mysqli("localhost","root","1234","timetablesystem");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$id = $_GET['id'];
$conn->query("DELETE FROM timetable WHERE id=$id");
header("Location: view_timetable.php");
?>